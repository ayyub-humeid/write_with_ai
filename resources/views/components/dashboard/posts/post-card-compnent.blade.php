    @props(['post' => []])
    <div id = 'post-{{ $post->id }}'
        class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant hover:border-primary transition-all group">
        <div class="flex items-start gap-4">
            <input class="mt-2 w-4 h-4 rounded border-outline text-primary focus:ring-primary" type="checkbox" />
            <div class="flex-grow grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <div class="md:col-span-6">
                    <span class="text-metadata font-metadata text-primary mb-1 block">Editorial • 8 min
                        read</span>
                    <h3 class="font-headline-md text-[20px] leading-snug group-hover:text-primary transition-colors">
                        {{ $post->title }}
                    </h3>
                    <p class="text-metadata font-metadata text-on-surface-variant mt-1">Published on
                        {{ $post->created_at->format('M j, Y') }}</p>
                </div>
                <div class="md:col-span-2 flex flex-col">
                    <span class="text-metadata font-metadata text-outline">Engagement</span>
                    <div class="flex items-center gap-4 mt-1">
                        <div class="flex items-center gap-1 text-ui-label font-medium">
                            <span class="material-symbols-outlined text-[18px]" data-icon="visibility"></span>
                            {{ Illuminate\Support\Number::abbreviate($post->views) }}

                            </span>



                        </div>
                        <div class="flex items-center gap-1 text-ui-label font-medium">
                            <span class="material-symbols-outlined text-[18px]"
                                data-icon="chat_bubble">chat_bubble</span> 84
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-700 text-[12px] font-bold border border-green-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span> {{ $post->status }}
                    </span>
                </div>
                <div class="md:col-span-2 flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('dashboard.posts.edit', [$post->id]) }}"
                        class="p-2 text-on-surface-variant hover:bg-surface-container hover:text-primary rounded-lg transition-all"
                        title="Edit">
                        <span class="material-symbols-outlined" data-icon="edit">edit</span>
                    </a>
                    {{-- <button
                        class="p-2 text-on-surface-variant hover:bg-surface-container hover:text-primary rounded-lg transition-all"
                        title="Analytics">
                        <span class="material-symbols-outlined" data-icon="bar_chart">bar_chart</span>
                    </button> --}}
                    <button
                        onclick="showConfirmModal({ title: 'Delete Post', message: 'Are you sure you want to permanently delete this post? This action cannot be undone.', confirmText: 'Delete', type: 'danger' }).then(confirmed => { if (confirmed) deletePost({{ $post->id }}, '{{ strtolower($post->status) }}'); });"
                        class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-all"
                        title="Delete">
                        <span class="material-symbols-outlined" data-icon="delete">delete</span>
                    </button>
                    {{-- <form style="display: none;" id="deletepost{{ $post->id }}"
                        action="{{ route('dashboard.posts.destroy', $post->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                    </form> --}}
                    <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-all"
                        title="More">
                        <span class="material-symbols-outlined" data-icon="more_vert">more_vert</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- <script>
        function deletePost(id, status) {
            console.log('Deleting post ' + id + ' with status ' + status);
            fetch('{{ route('dashboard.posts.destroy', ':id') }}'.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert('Post deleted successfully.');
                        document.getElementById('post-' + id).remove();

                        // Decrement the count element in DOM
                        const countEl = document.getElementById('count-' + status);
                        if (countEl) {
                            let currentCount = parseInt(countEl.textContent, 10);
                            if (!isNaN(currentCount) && currentCount > 0) {
                                countEl.textContent = currentCount - 1;
                            }
                        }
                    } else {
                        alert('Failed to delete the post.');
                    }
                });
        }
    </script> -->
