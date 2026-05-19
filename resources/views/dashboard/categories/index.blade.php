@extends('layouts.main')

@section('title', 'Category Management')

@section('content')
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="max-w-2xl pt-16">
            <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Category Management</h1>
            <p class="font-body-md text-on-surface-variant">Organize your content structure, monitor performance metrics, and refine your editorial taxonomy for maximum audience engagement.</p>
        </div>
        <a href="{{ route('dashboard.categories.create') }}" 
            class="bg-primary text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
            <span class="material-symbols-outlined">add</span>
            Create Category
        </a>
    </header>

    @if($categories->isEmpty())
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
        <!-- Search and Layout Toggle -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8">
            <div class="relative w-full md:w-96">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input id="category-search" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl pl-12 pr-4 py-3 font-ui-label text-ui-label focus:border-primary outline-none transition-all" placeholder="Filter categories by name..." type="text"/>
            </div>
            <div class="flex items-center gap-2 bg-surface-container-low p-1 rounded-lg">
                <button class="p-2 bg-surface-container-lowest text-primary rounded shadow-sm">
                    <span class="material-symbols-outlined">grid_view</span>
                </button>
                <button class="p-2 text-on-surface-variant">
                    <span class="material-symbols-outlined">list</span>
                </button>
            </div>
        </div>

        <!-- Bento Categories Grid component -->
        <x-dashboard.categories.category-component :categories="$categories" />

        <!-- All Categories detailed listing table component -->
        <section class="mt-20">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-8">All Categories</h3>
            <x-dashboard.categories.category-table :categories="$categories" />
        </section>
    @endif
@endsection

@section('mainClass', 'pt-12 pb-section-gap px-gutter max-w-container-max mx-auto')
@section('bodyClass', 'bg-surface text-on-surface font-body-md')

@push('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
@endpush

@section('script')
<script>
    function deleteCategory(id) {
        showConfirmModal({
            title: 'Delete Category',
            message: 'Are you sure you want to delete this category? All nested child categories and post associations will be updated or deleted.',
            confirmText: 'Delete Category',
            confirmColor: 'error'
        }).then((confirmed) => {
            if (confirmed) {
                const url = '{{ route('dashboard.categories.destroy', ':id') }}'.replace(':id', id);
                
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json().then(data => ({ ok: response.ok, body: data })))
                .then(({ ok, body }) => {
                    if (ok) {
                        showToast(body.message || 'Category deleted successfully.', 'success');
                        
                        // 1. Smoothly fade/collapse bento card
                        const card = document.getElementById('category-card-' + id);
                        if (card) {
                            card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.95)';
                            setTimeout(() => { card.remove(); }, 400);
                        }

                        // 2. Smoothly fade/collapse table row
                        const row = document.getElementById('category-row-' + id);
                        if (row) {
                            row.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                            row.style.opacity = '0';
                            row.style.backgroundColor = 'rgba(186, 26, 26, 0.05)';
                            setTimeout(() => { row.remove(); }, 400);
                        }

                        // If no elements remain, soft reload to show empty state
                        setTimeout(() => {
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                window.location.reload();
                            }
                        }, 500);
                    } else {
                        showToast(body.message || 'Failed to delete category.', 'error');
                    }
                })
                .catch(err => {
                    console.error('Category delete error:', err);
                    showToast('An error occurred while deleting the category.', 'error');
                });
            }
        });
    }

    // Real-time clientside category search filter
    const searchInput = document.getElementById('category-search');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            
            // 1. Filter Bento Cards
            document.querySelectorAll('[id^="category-card-"]').forEach(card => {
                const title = card.querySelector('h2');
                const desc = card.querySelector('p');
                const titleText = title ? title.textContent.toLowerCase() : '';
                const descText = desc ? desc.textContent.toLowerCase() : '';
                
                if (titleText.includes(query) || descText.includes(query)) {
                    card.style.display = '';
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // 2. Filter Table Rows
            document.querySelectorAll('[id^="category-row-"]').forEach(row => {
                const title = row.querySelector('.font-headline-md');
                const slug = row.querySelector('.font-metadata');
                const titleText = title ? title.textContent.toLowerCase() : '';
                const slugText = slug ? slug.textContent.toLowerCase() : '';
                
                if (titleText.includes(query) || slugText.includes(query)) {
                    row.style.display = '';
                    row.style.opacity = '1';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>
@endsection
