@props(['categories' => []])

@if ($categories->isEmpty())
    <!-- Empty State fallback -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-16 text-center flex flex-col items-center justify-center gap-4 w-full">
        <span class="material-symbols-outlined text-[64px] text-secondary">category</span>
        <h2 class="text-2xl font-bold text-on-surface">No categories found</h2>
        <p class="text-on-surface-variant max-w-sm">Create your first category to start organizing your intellectual output and structuring your writing taxonomy.</p>
        <a href="{{ route('dashboard.categories.create') }}" 
            class="bg-primary text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button hover:opacity-95 transition-all">
            Add New Category
        </a>
    </div>
@else
    @php
        $topCategory = $categories->first();
        $otherCategories = $categories->skip(1)->take(3);
    @endphp

    <!-- Category Grid (Asymmetric Bento-inspired layout) -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 w-full">
        <!-- Top Performing Bento Slot -->
        @if ($topCategory)
            <x-dashboard.categories.category-card :category="$topCategory" :isLarge="true" />
        @endif

        <!-- Standard Bento Slots -->
        @foreach ($otherCategories as $category)
            <x-dashboard.categories.category-card :category="$category" :isLarge="false" />
        @endforeach

        <!-- Add Category Bento link -->
        <a href="{{ route('dashboard.categories.create') }}" class="md:col-span-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 border-dashed flex flex-col items-center justify-center text-center opacity-60 hover:opacity-100 hover:bg-surface transition-all cursor-pointer min-h-[250px]">
            <div class="w-12 h-12 rounded-full border border-outline-variant flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-on-surface-variant">add</span>
            </div>
            <p class="font-ui-label text-ui-label font-bold text-on-surface">Add Category</p>
            <p class="font-metadata text-metadata text-on-surface-variant mt-1">Draft a new category skeleton</p>
        </a>
    </div>
@endif
