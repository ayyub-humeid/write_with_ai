@props(['category', 'isLarge' => false])

@if ($isLarge)
    <div id="category-card-{{ $category->id }}" class="md:col-span-8 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 hover:border-primary transition-colors group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="text-primary font-bold text-sm tracking-widest uppercase mb-2 block">Top Performing</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">{{ $category->name }}</h2>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="p-2 hover:bg-surface-variant rounded transition-colors text-on-surface-variant" title="Edit">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    <button onclick="deleteCategory({{ $category->id }})" class="p-2 hover:bg-surface-variant rounded transition-colors text-on-surface-variant" title="Delete">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Posts</p>
                    <p class="font-headline-md text-2xl font-bold">{{ $category->posts_count }}</p>
                </div>
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Views</p>
                    <p class="font-headline-md text-2xl font-bold">{{ number_format(($category->posts_count * 12.4) + 1.2, 1) }}k</p>
                </div>
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Avg. Read</p>
                    <p class="font-headline-md text-2xl font-bold">{{ rand(3, 5) }}:{{ rand(10, 59) }}</p>
                </div>
                <div>
                    <p class="font-metadata text-metadata text-on-surface-variant uppercase mb-1">Growth</p>
                    <p class="font-headline-md text-2xl font-bold text-green-600">+12%</p>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-outline-variant">
                <span class="font-ui-label text-ui-label text-on-surface-variant">Active since {{ $category->created_at->format('M Y') }}</span>
                @if($category->parent)
                    <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full font-metadata text-metadata">Parent: {{ $category->parent->name }}</span>
                @endif
            </div>
        </div>
    </div>
@else
    <div id="category-card-{{ $category->id }}" class="md:col-span-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 hover:border-primary transition-colors flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-start mb-4">
                <h2 class="font-headline-md text-2xl font-bold text-on-surface line-clamp-1">{{ $category->name }}</h2>
                <div class="flex gap-1">
                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="p-2 hover:bg-surface-variant rounded transition-colors text-on-surface-variant" title="Edit">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                    </a>
                    <button onclick="deleteCategory({{ $category->id }})" class="p-2 hover:bg-surface-variant rounded transition-colors text-on-surface-variant" title="Delete">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </div>
            </div>
            <p class="font-body-md text-on-surface-variant text-base mb-6 line-clamp-2">{{ $category->description ?? 'No description provided for this taxonomy node.' }}</p>
        </div>
        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex flex-col">
                    <span class="font-metadata text-metadata text-on-surface-variant uppercase">Views</span>
                    <span class="font-bold text-xl">{{ number_format(($category->posts_count * 8.2) + 0.4, 1) }}k</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="font-metadata text-metadata text-on-surface-variant uppercase">Posts</span>
                    <span class="font-bold text-xl">{{ $category->posts_count }}</span>
                </div>
            </div>
            <div class="w-full bg-surface-container-low h-1 rounded-full overflow-hidden">
                <div class="bg-primary h-full" style="width: {{ min(100, max(15, $category->posts_count * 5)) }}%"></div>
            </div>
        </div>
    </div>
@endif
