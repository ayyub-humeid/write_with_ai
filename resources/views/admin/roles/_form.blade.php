<form action="{{ $action ?? route('admin.roles.store') }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    @if ($errors->any())
        <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm animate-shake">
            <div class="flex items-center mb-3">
                <span class="material-symbols-outlined text-red-500 mr-2">error</span>
                <h4 class="font-ui-label text-ui-label text-red-700 font-bold">Whoops! Something went wrong</h4>
            </div>
        </div>
    @endif

    <main class="pt-24 pb-32 flex flex-col md:flex-row max-w-container-max mx-auto px-gutter gap-12">

        <!-- Editor Canvas -->
        <div class="flex-1 max-w-article-max mx-auto w-full distraction-free-focus">
            <div class="editor-container">
                <!-- Title Field -->
                <input type="text" name="name" value="{{ old('name', $post->name) }}"
                    class="w-full bg-transparent border-b-2 {{ $errors->has('name') ? 'border-error' : 'border-transparent hover:border-outline-variant' }} focus:ring-0 font-display-lg text-display-lg resize-none placeholder:text-surface-variant text-on-surface mb-2 overflow-hidden transition-colors"
                    placeholder="Role Name...">
                @error('name')
                    <div class="text-error font-metadata text-metadata mb-8 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">warning</span>
                        {{ $message }}
                    </div>
                @else
                    <div class="mb-8"></div>
                @enderror
                <!-- description Field -->
                <textarea name="description"
                    class="w-full bg-transparent border-b-2 {{ $errors->has('description') ? 'border-error' : 'border-transparent hover:border-outline-variant' }} focus:ring-0 font-body-lg text-body-lg text-on-surface leading-relaxed placeholder:text-surface-variant transition-colors"
                    data-placeholder="Type your story..." oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'>{{ old('description', $role->description) }}</textarea>
                @error('description')
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
                {{ isset($post->id) ? 'Update Role' : 'Create' }}
            </button>
        </div>
        <!-- Sidebar: Publishing Settings -->

    </main>
</form>


