<?php
 
namespace App\Http\Controllers\Dashboard;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::with('parent')
            ->withCount('posts')
            ->latest()
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.dashboard.categories.category-component', compact('categories'))->render(),
                'count' => $categories->count()
            ]);
        }

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        $parent_categories = Category::select('id', 'name')->get();
        return view('dashboard.categories.create', compact('category', 'parent_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Auto-generate slug if not explicitly provided


        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            
        ]);
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        Category::create($validated);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with(['parent', 'children', 'posts'])->findOrFail($id);
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        // Exclude the current category itself to prevent self-nesting loops
        $parent_categories = Category::where('id', '!=', $id)
            ->select('id', 'name')
            ->get();

        return view('dashboard.categories.edit', compact('category', 'parent_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Auto-generate slug if not explicitly provided
        if (!$request->filled('slug') && $request->filled('name')) {
            $request->merge(['slug' => Str::slug($request->input('name'))]);
        }

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'parent_id'   => ['nullable', 'exists:categories,id', 'different:id'],
        ]);

        $category->update($validated);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
                'count'   => Category::count()
            ]);
        }

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
