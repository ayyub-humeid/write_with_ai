<form action="{{ $action ?? route('dashboard.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method ?? 'POST')

    @if ($errors->any())
        <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm animate-shake">
            <div class="flex items-center mb-3">
                <span class="material-symbols-outlined text-red-500 mr-2">error</span>
                <h4 class="font-ui-label text-ui-label text-red-700 font-bold">Whoops! Something went wrong</h4>
            </div>
            <!-- <ul class="list-none space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-red-600 font-metadata text-metadata flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                        {{ $error }}
                    </li>
                @endforeach
            </ul> -->
        </div>
    @endif

    <main class="pt-24 pb-32 flex flex-col md:flex-row max-w-container-max mx-auto px-gutter gap-12">

        <!-- Editor Canvas -->
        <div class="flex-1 max-w-article-max mx-auto w-full distraction-free-focus">
            <div class="editor-container">
                <!-- Title Field -->
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                    class="w-full bg-transparent border-b-2 {{ $errors->has('title') ? 'border-error' : 'border-transparent hover:border-outline-variant' }} focus:ring-0 font-display-lg text-display-lg resize-none placeholder:text-surface-variant text-on-surface mb-2 overflow-hidden transition-colors"
                    placeholder="Enter your title...">
                @error('title')
                    <div class="text-error font-metadata text-metadata mb-8 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">warning</span>
                        {{ $message }}
                    </div>
                @else
                    <div class="mb-8"></div>
                @enderror
                <!-- Content Field -->
                <textarea name="content"
                    class="w-full bg-transparent border-b-2 {{ $errors->has('content') ? 'border-error' : 'border-transparent hover:border-outline-variant' }} focus:ring-0 font-body-lg text-body-lg text-on-surface leading-relaxed placeholder:text-surface-variant transition-colors"
                    data-placeholder="Type your story..." oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="text-error font-metadata text-metadata mt-2 mb-8 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">warning</span>
                        {{ $message }}
                    </div>
                @else
                    <div class="mb-8"></div>
                @enderror
            </div>
            <button type="submit"
                class="bg-primary text-on-primary px-8 py-4 rounded-full font-ui-label text-ui-label hover:bg-primary-hover transition-all hover:shadow-lg active:scale-95 flex items-center gap-2">
                <span class="material-symbols-outlined">publish</span>
                {{ isset($post->id) ? 'Update Post' : 'Publish Story' }}
            </button>
        </div>
        <!-- Sidebar: Publishing Settings -->
        <aside
            class="hidden lg:block w-80 shrink-0 h-fit sticky top-24 sidebar-overlay transition-opacity duration-500">
            <div class="space-y-8 border-l border-outline-variant pl-8">
                <!-- Cover Image -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Cover
                        Image
                    </h3>
                    <div id="image-preview-container" 
                        class="relative aspect-video w-full rounded-2xl bg-surface-container border-2 {{ $errors->has('cover_image') ? 'border-error' : 'border-dashed border-outline-variant' }} flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-surface-container-high transition-all group overflow-hidden shadow-inner">
                        
                        <input type="hidden" name="remove_cover_image" id="remove-cover-image" value="0">
                        
                        <div class="absolute inset-0 z-0" onclick="document.getElementById('cover-image').click()">
                            @if ($post->cover_image)
                                <img id="preview-img" src="{{ asset('storage/' . $post->cover_image) }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <img id="preview-img" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            @endif

                            <div id="preview-placeholder" class="{{ $post->cover_image ? 'opacity-0' : 'opacity-100' }} flex flex-col items-center justify-center gap-2 group-hover:scale-110 transition-transform duration-300 h-full w-full">
                                <span class="material-symbols-outlined text-[48px] text-secondary group-hover:text-primary transition-colors">add_a_photo</span>
                                <span class="font-metadata text-metadata text-secondary">Upload Cover Photo</span>
                            </div>

                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-white font-ui-label text-ui-label">Change Image</span>
                            </div>
                        </div>

                        <!-- Delete Button (Only visible if image exists/selected) -->
                        <button type="button" id="remove-image-btn" 
                                onclick="clearImageSelection(event)"
                                class="{{ $post->cover_image ? 'flex' : 'hidden' }} absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-error text-on-error items-center justify-center shadow-md hover:bg-error-hover transition-all active:scale-90">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>

                        <input type="file" name="cover_image" id="cover-image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                    @error('cover_image')
                        <div class="text-error font-metadata text-metadata mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">warning</span>
                            {{ $message }}
                        </div>
                    @enderror
                </section>
                <!-- Category Select -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Category</h3>
                    <div class="relative">
                        <select name="category_id"
                            class="w-full appearance-none bg-white border {{ $errors->has('category_id') ? 'border-error' : 'border-outline-variant' }} rounded-xl px-4 py-3 font-metadata text-metadata text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer shadow-sm pr-10">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (old('category_id', $post->category_id) == $category->id) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-secondary">
                            <span class="material-symbols-outlined text-[20px]">keyboard_arrow_down</span>
                        </div>
                    </div>
                    @error('category_id')
                        <div class="text-error font-metadata text-metadata mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">warning</span>
                            {{ $message }}
                        </div>
                    @enderror
                </section>
                <!-- Tags -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Tags</h3>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span
                            class="bg-primary-fixed text-on-primary-fixed px-3 py-1 rounded-full font-metadata text-metadata flex items-center gap-1">
                            Minimalism <span class="material-symbols-outlined text-[14px] cursor-pointer">close</span>
                        </span>
                        <span
                            class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-metadata text-metadata flex items-center gap-1">
                            Writing <span class="material-symbols-outlined text-[14px] cursor-pointer">close</span>
                        </span>
                    </div>
                    <input
                        class="w-full bg-white border border-outline-variant rounded-lg px-4 py-2 font-metadata text-metadata focus:ring-1 focus:ring-primary focus:border-primary transition-all shadow-sm"
                        placeholder="Add tag..." type="text" />
                </section>
                <!-- SEO Preview -->
                <section>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-ui-label text-ui-label text-on-surface uppercase tracking-wider">SEO Preview</h3>
                        <button type="button" class="text-primary font-metadata text-metadata hover:underline">Edit</button>
                    </div>
                    <div class="p-4 bg-white border border-outline-variant rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-[#1a0dab] font-sans text-[18px] leading-tight mb-1 truncate">
                            {{ $post->title ? $post->title . ' | Ink & Paper' : 'Story Title Preview' }}
                        </div>
                        <div class="text-[#006621] font-sans text-[14px] mb-1 truncate">inkandpaper.com/{{ Str::slug($post->title ?? 'new-post') }}</div>
                        <p class="text-secondary font-sans text-[13px] line-clamp-2">
                            {{ Str::limit(strip_tags($post->content), 150, '...') ?: 'Start writing to see your SEO meta description preview here. This is how search engines like Google will display your story.' }}
                        </p>
                    </div>
                </section>
            </div>
        </aside>

    </main>
</form>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');
        const removeBtn = document.getElementById('remove-image-btn');
        const removeInput = document.getElementById('remove-cover-image');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('opacity-0');
                removeBtn.classList.remove('hidden');
                removeBtn.classList.add('flex');
                removeInput.value = "0"; // Reset remove flag if new file selected
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImageSelection(event) {
        event.stopPropagation(); // Avoid triggering file input
        
        const input = document.getElementById('cover-image');
        const preview = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');
        const removeBtn = document.getElementById('remove-image-btn');
        const removeInput = document.getElementById('remove-cover-image');
        
        input.value = ""; // Clear file input
        preview.src = "";
        preview.classList.add('hidden');
        placeholder.classList.remove('opacity-0');
        removeBtn.classList.add('hidden');
        removeBtn.classList.remove('flex');
        removeInput.value = "1"; // Signal that existing image should be removed
    }
</script>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.4s ease-in-out;
    }
</style>
