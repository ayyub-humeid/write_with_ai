@props(['category'])

<tr id="category-row-{{ $category->id }}" class="hover:bg-surface transition-colors">
    <td class="px-6 py-4">
        <div class="font-headline-md text-xl font-bold text-on-surface">{{ $category->name }}</div>
        <div class="font-metadata text-metadata text-on-surface-variant">/categories/{{ $category->slug }}</div>
    </td>
    <td class="px-6 py-4">
        @if($category->parent_id)
            <span class="px-2.5 py-1 bg-primary-container/20 text-primary rounded-md text-xs font-semibold">Subcategory</span>
        @else
            <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-md text-xs font-semibold">Root Category</span>
        @endif
    </td>
    <td class="px-6 py-4 font-ui-label text-ui-label text-on-surface">{{ $category->posts_count }}</td>
    <td class="px-6 py-4 font-ui-label text-ui-label text-on-surface">{{ number_format(($category->posts_count * 10.4) + 0.5, 1) }}k</td>
    <td class="px-6 py-4 text-right">
        <div class="flex justify-end gap-3">
            <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="text-on-surface-variant hover:text-primary transition-colors" title="Edit">
                <span class="material-symbols-outlined">edit</span>
            </a>
            <button onclick="deleteCategory({{ $category->id }})" class="text-on-surface-variant hover:text-error transition-colors" title="Delete">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </div>
    </td>
</tr>
