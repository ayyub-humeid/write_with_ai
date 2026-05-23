@props(['posts' => []])
<div class="space-y-4">
    @foreach ($posts as $post)
        <x-dashboard.posts.post-card-compnent :post="$post" />
    @endforeach
</div>

@if ($posts->hasPages())
    <div class="flex items-center justify-between pt-8 border-t border-outline-variant mt-8">
        <span class="text-metadata font-metadata text-on-surface-variant">
            Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ number_format($posts->total()) }} posts
        </span>
        
        <div class="flex gap-2">
            {{-- Previous Page --}}
            @if ($posts->onFirstPage())
                <button class="p-2 border border-outline-variant rounded-lg opacity-30 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
                </button>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low text-on-surface transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
                </a>
            @endif

            {{-- Page Range --}}
            @php
                $start = max(1, $posts->currentPage() - 2);
                $end = min($posts->lastPage(), $posts->currentPage() + 2);
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $posts->currentPage())
                    <button class="h-10 w-10 border border-primary bg-primary text-on-primary rounded-lg font-ui-label flex items-center justify-center font-bold">
                        {{ $page }}
                    </button>
                @else
                    <a href="{{ $posts->url($page) }}" class="h-10 w-10 border border-outline-variant hover:bg-surface-container-low rounded-lg font-ui-label flex items-center justify-center text-on-surface transition-all">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Next Page --}}
            @if ($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low text-on-surface transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
                </a>
            @else
                <button class="p-2 border border-outline-variant rounded-lg opacity-30 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
                </button>
            @endif
        </div>
    </div>
@endif
