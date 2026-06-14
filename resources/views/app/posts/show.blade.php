@extends('layouts.main')

@section('content')
    <article class="mx-auto article-column px-margin-mobile md:px-0">
        <!-- Headline -->
        <header class="mb-12">
            <h1 class="font-display-lg text-display-lg mb-8 text-on-surface">{{ $post?->title }} </h1>
            <!-- Author Bio -->
            <div class="flex items-center justify-between py-6 border-y border-outline-variant">
                <div class="flex items-center gap-4">
                    <img class="w-12 h-12 rounded-full grayscale"
                        data-alt="A close-up portrait of a thoughtful writer in a minimalist studio setting. The lighting is soft and directional, creating a gentle chiaroscuro effect. The image is rendered in a premium black and white style to match the editorial and high-contrast digital quiet aesthetic."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrB-fTH_sGc-EoJs3tiJjk17n12cNKJM223VhyTD5FfEtDknySO7GKIj0HvaJ3d-MoqtVOP8Yfk-dObjmX9mmt7mFiMRgqqpHWCsYFFpmpKBTaBXmgoB4M75gSnf4MJhP1WCx3DUb1E9iLnP1S039Q9dKb0JB_82yuO9S-WADZqyUPUVc_7lpe6Od7eVj2dcesczICWUxGQu7qeDZM0cH-Zqb8erGsQU-AEaICg0K2DynpHlKKOtRY0rPe9qhTIpUEN05vqmFz9_FG" />
                    <div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('users.profile',['username'=>$post->user->namename??$post->user->name]) }}">
                                <span
                                    class="font-ui-label text-ui-label font-bold text-on-surface">{{ $post->user->name }}</span>
                            </a>
                            <span class="text-secondary-fixed-dim">•</span>
                            @if(Auth::check() && Auth::id() != $post->user_id)
                                <button id="follow-btn-{{ $post->user_id }}"
                                    onclick="{{ Auth::user()->followings->contains($post->user_id) ? "unfollow($post->user_id)" : "follow($post->user_id)" }}"
                                    class="text-primary font-ui-label text-ui-label font-semibold hover:underline">
                                    {{ Auth::user()->followings->contains($post->user_id) ? 'Unfollow' : 'Follow' }}
                                </button>
                            @elseif(!Auth::check())
                                <a href="{{ route('login') }}" class="text-primary font-ui-label text-ui-label font-semibold hover:underline">Follow</a>
                            @endif
                        </div>
                        <p class="font-metadata text-metadata text-secondary">{{ $post->created_at->format('M j, Y') }} · 12
                            min read</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button
                        class="material-symbols-outlined text-secondary hover:text-primary transition-colors">share</button>
                    <button
                        class="material-symbols-outlined text-secondary hover:text-primary transition-colors">more_horiz</button>
                </div>
            </div>
        </header>
        <!-- Content -->
        <div class="space-y-8">
            {!! $post->content !!}
            <div class="my-12">
                <img class="w-full rounded-lg border border-outline-variant"
                    data-alt="A stunning, minimalist architectural shot of a brightly lit gallery space with clean lines and vast open areas. The lighting is natural and airy, emphasizing the feeling of digital quiet and editorial focus. The palette is dominated by soft whites and sharp charcoal accents, reflecting a modern minimalist philosophy."
                    src="{{ $post->thumbnailUrl }}" />
                <p class="font-metadata text-metadata text-center mt-4 text-secondary italic">Figure 1.1: The visual
                    representation of cognitive breathing room in physical architecture.</p>
            </div>
            <blockquote class="pl-6 border-l-4 border-primary my-12 italic">
                <p class="font-body-lg text-body-lg text-on-surface">"True design is reached not when there is
                    nothing left to add, but when there is nothing left to take away from the core message."</p>
            </blockquote>
            <h3 class="font-ui-label text-ui-label font-bold uppercase tracking-wider text-primary">Intentional
                Constraints</h3>
            <p class="font-body-md text-body-md text-on-surface">
                Standardizing column widths to 720px is more than a convention. It respects the physiological limits
                of the human eye, ensuring that the transition from the end of one line to the beginning of the next
                remains fluid and effortless. Any wider, and the brain begins to work too hard just to track the
                sequence.
            </p>
            <div class="p-8 bg-surface-container rounded-lg border border-outline-variant my-12">
                <h4 class="font-ui-label text-ui-label font-bold mb-4">Key Takeaways for Designers</h4>
                <ul class="space-y-3 font-body-md text-body-md text-on-surface">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        Prioritize monochromatic foundations for reading areas.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        Use 8px-based spacing for a rigorous vertical rhythm.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        Introduce a single high-energy digital accent (e.g., Electric Violet).
                    </li>
                </ul>
            </div>
        </div>
    </article>

    <!-- Floating Engagement Bar -->
    <div class="fixed bottom-10 left-1/2 -translate-x-1/2 z-40">
        <div
            class="flex items-center gap-6 px-6 py-3 bg-white rounded-full border border-outline-variant shadow-[0_20px_30px_rgba(26,26,26,0.05)] backdrop-blur-sm">
            <div class="flex items-center gap-2 group cursor-pointer" onclick="toggleLike({{ $post->id }})">
                <span id="like-btn-{{ $post->id }}"
                    class="material-symbols-outlined transition-colors {{ Auth::check() && $post->isLikedBy(Auth::user()) ? 'bg-red-500 text-white rounded-full p-1' : 'text-on-surface-variant group-hover:text-primary' }}">favorite</span>
                <span id="like-count-{{ $post->id }}" class="font-ui-label text-ui-label text-secondary group-hover:text-primary">{{ $post->likes->count() }}</span>
            </div>
            <div class="w-px h-6 bg-outline-variant"></div>
            <div class="flex items-center gap-2 group cursor-pointer" onclick="openCommentsModal({{ $post->id }}, {{ $post->comments_count }})">
                <span
                    class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">chat_bubble</span>
                <button onclick="openCommentsModal({{ $post->id }}, {{ $post->comments_count }})">
                    <span class="font-ui-label text-ui-label text-secondary group-hover:text-primary">
                        {{ $post->comments_count }} </span>
                </button>


            </div>
            <div class="w-px h-6 bg-outline-variant"></div>
            <button
                class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">bookmark</button>
            <button
                class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">ios_share</button>

        </div>
    </div>

@endsection

@include('dashboard.posts.includes.commentsModel')

@push('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .article-column {
            max-width: 720px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }
    </style>
@endpush
@section('script')
    <script>
        let activePostId = null;

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        }

        function closeCommentsModal() {
            const modal = document.getElementById('commentsModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function renderComments(comments) {
            const list = document.getElementById('commentsList');
            if (!list) return;

            if (!comments.length) {
                list.innerHTML = `
                <div class="h-full min-h-[240px] flex flex-col items-center justify-center gap-3">
                    <div class="p-4 bg-gray-100 rounded-full">
                        <span class="material-symbols-outlined text-gray-400 text-[32px]">chat_bubble_outline</span>
                    </div>
                    <p class="text-center">
                        <p class="text-sm font-medium text-gray-600">No comments yet</p>
                        <p class="text-xs text-gray-500 mt-1">Be the first to share your thoughts</p>
                    </p>
                </div>
            `;
                return;
            }

            list.innerHTML = comments.map((comment, index) => `
            <article class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-300 hover:border-gray-300 animate-fade-in-up" style="animation-delay: ${index * 50}ms">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">${escapeHtml(comment.author).charAt(0).toUpperCase()}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-gray-900 truncate">${escapeHtml(comment.author)}</h4>
                            <time class="text-xs text-gray-500 font-medium" title="${escapeHtml(comment.created_at || '')}">
                                ${escapeHtml(comment.created_at_human || '')}
                            </time>
                        </div>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-gray-700 whitespace-pre-line break-words">${escapeHtml(comment.content || '')}</p>
            </article>
        `).join('');
        }

        function openCommentsModal(postId, commentsCount = 0) {
            console.log('Opening comments modal for post ID:', postId, 'with', commentsCount, 'comments');
            activePostId = postId;
            const modal = document.getElementById('commentsModal');
            const list = document.getElementById('commentsList');
            const loader = document.getElementById('commentsLoader');
            const meta = document.getElementById('commentsMeta');

            if (!modal || !list || !loader || !meta) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            meta.textContent = `${commentsCount} comment${commentsCount === 1 ? '' : 's'}`;
            list.innerHTML = '';
            loader.classList.remove('hidden');

            const url = '{{ route('posts.comments', ':id') }}'.replace(':id', postId);

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json().then(data => ({
                    ok: response.ok,
                    body: data
                })))
                .then(({
                    ok,
                    body
                }) => {
                    if (activePostId !== postId) return;

                    loader.classList.add('hidden');
                    if (!ok) {
                        console.log('Comments API response:', body);

                        showToast(body.message || 'Failed to load comments.', 'error');
                        renderComments([]);
                        return;
                    }

                    meta.textContent =
                        `${body.comments_count || 0} comment${(body.comments_count || 0) === 1 ? '' : 's'}`;
                    renderComments(body.comments || []);
                })
                .catch(() => {
                    if (activePostId !== postId) return;
                    loader.classList.add('hidden');
                    showToast('An error occurred while loading comments.', 'error');
                    renderComments([]);
                });
        }
        function submitCommentModal() {
            if (!activePostId) return;
            const content = document.getElementById('comment-content-modal').value;
            if (!content.trim()) return;

            const url = '{{ route('posts.comment', ':id') }}'.replace(':id', activePostId);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        content: content
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('comment-content-modal').value = '';
                        openCommentsModal(activePostId); // Refresh comments
                    }
                })
                .catch(error => {
                    console.error('Comment error:', error);
                });
        }
    </script>
@endsection

@section('mainClass', 'pt-24 pb-section-gap')
@section('bodyClass', 'bg-surface text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed')
