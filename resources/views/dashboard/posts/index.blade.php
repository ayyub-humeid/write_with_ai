@extends('layouts.main')
@section('title', 'Manage Posts')
@section('content')
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class=" pt-16 font-display-lg text-display-lg text-on-background mb-2">Content Management</h1>
            <p class="text-on-surface-variant max-w-lg font-ui-label text-ui-label">Manage your intellectual output,
                track performance, and schedule your upcoming editorial pieces.</p>
        </div>
        <a href="{{ route('dashboard.posts.create') }}"
            class="bg-primary-container text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-sm">
            <span class="material-symbols-outlined text-[20px]" data-icon="edit_square">edit_square</span>
            Create Post
        </a>
    </div>
    <!-- Dashboard Layout Grid -->
    <div class="grid grid-cols-12 gap-8">
        <!-- Sidebar / Stats (Bento Style) -->
        @include('dashboard.posts.includes.aside')
        <!-- Main Content Area -->
        <div class="col-span-12 lg:col-span-9 space-y-6">


            <!-- Tabs & Search Filter component -->

            <x-dashboard.posts.filter-tab-component :status="$status" :status_options="$status_options" />
            <!-- Bulk Actions Bar (Sticky-ish) -->
            <div
                class="bg-surface-container-low px-4 py-3 rounded-lg flex items-center justify-between border border-outline-variant">
                <div class="flex items-center gap-4">
                    <input class="w-4 h-4 rounded border-outline text-primary focus:ring-primary" type="checkbox" />
                    <span class="text-metadata font-ui-label font-medium text-on-surface-variant">2 posts
                        selected</span>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="text-metadata font-ui-label font-semibold text-secondary hover:text-on-surface transition-all">Unpublish</button>
                    <span class="w-px h-4 bg-outline-variant"></span>
                    <button
                        class="text-metadata font-ui-label font-semibold text-error hover:text-on-error-container transition-all">Delete</button>
                </div>
            </div>
            <!-- Post Table/List -->
            <div id="posts-container" class="transition-opacity duration-300">
                <x-dashboard.posts.post-component :posts="$posts" />
            </div>
            <!-- Pagination -->
            <!-- end  Tabs & Search Filter component -->


        </div>
    </div>
@endsection

@section('mainClass', 'flex-grow w-full max-w-container-max mx-auto px-gutter py-12')
@section('bodyClass', 'bg-surface text-on-surface min-h-screen flex flex-col font-body-md')
@push('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 200, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        body {
            background-color: #f9f9f9;
            color: #1a1c1c;
        }
    </style>
@endpush

@section('script')
<script>
    // Global function to delete a post with AJAX
    function deletePost(id, status) {
        console.log('Deleting post ' + id + ' with status ' + status);
        const url = '{{ route('dashboard.posts.destroy', ':id') }}'.replace(':id', id);
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json().then(data => ({ ok: response.ok, body: data })))
        .then(({ ok, body }) => {
            if (ok) {
                showToast(body.message || 'Post deleted successfully.', 'success');
                
                const postCard = document.getElementById('post-' + id);
                if (postCard) {
                    postCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                    postCard.style.opacity = '0';
                    postCard.style.transform = 'translateY(15px)';
                    postCard.style.maxHeight = postCard.offsetHeight + 'px';
                    setTimeout(() => {
                        postCard.style.maxHeight = '0px';
                        postCard.style.paddingTop = '0px';
                        postCard.style.paddingBottom = '0px';
                        postCard.style.marginTop = '0px';
                        postCard.style.marginBottom = '0px';
                        postCard.style.borderWidth = '0px';
                    }, 100);
                    setTimeout(() => {
                        postCard.remove();
                    }, 400);
                }

                // Update count in UI
                const countEl = document.getElementById('count-' + status);
                if (countEl) {
                    let currentCount = parseInt(countEl.textContent, 10);
                    if (!isNaN(currentCount) && currentCount > 0) {
                        countEl.textContent = currentCount - 1;
                    }
                }
            } else {
                showToast(body.message || 'Failed to delete post.', 'error');
            }
        })
        .catch(err => {
            console.error('Delete error:', err);
            showToast('An error occurred while deleting the post.', 'error');
        });
    }

    // Tab switching without page reload (complete taping/tabbing with JS)
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-link');
        const container = document.getElementById('posts-container');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const status = tab.getAttribute('data-status');
                const targetUrl = tab.getAttribute('href');

                // Visual feed-forward feedback: highlight active tab & dim container
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-primary', 'text-primary'));
                tab.classList.add('border-b-2', 'border-primary', 'text-primary');

                if (container) {
                    container.style.opacity = '0.5';
                    container.style.pointerEvents = 'none';
                }

                // Fetch new posts via AJAX
                fetch(targetUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(data => ({ ok: response.ok, body: data })))
                .then(({ ok, body }) => {
                    if (container) {
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    }

                    if (ok) {
                        // Dynamically update the posts list
                        container.innerHTML = body.html;
                        
                        // Update active browser URL bar without reloading the page
                        window.history.pushState({ status: body.status }, '', targetUrl);

                        // Update the counters just in case they changed
                        if (body.counts) {
                            for (const [s, count] of Object.entries(body.counts)) {
                                const countEl = document.getElementById('count-' + s);
                                if (countEl) {
                                    countEl.textContent = count;
                                }
                            }
                        }
                    } else {
                        showToast('Failed to load posts.', 'error');
                    }
                })
                .catch(err => {
                    console.error('Tab switch error:', err);
                    if (container) {
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    }
                    showToast('An error occurred while switching tabs.', 'error');
                });
            });
        });

        // Keep dynamic tab state when user uses browser back/forward buttons
        window.addEventListener('popstate', (e) => {
            // Simply reload the page or trigger the click on correct tab
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status') || 'published';
            const matchingTab = document.querySelector(`.tab-link[data-status="${status}"]`);
            if (matchingTab) {
                window.location.reload();
            }
        });
    });
</script>
@endsection

