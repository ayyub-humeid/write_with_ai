<form action="{{ $action ?? route('dashboard.categories.store') }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 pt-16">
        <!-- Main Form Fields -->
        <div class="lg:col-span-8 bg-surface-container-lowest border border-outline-variant rounded-2xl p-8 shadow-sm space-y-6">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="p-4 bg-error-container text-on-error-container rounded-xl font-metadata text-metadata">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Category Name -->
            <div>
                <label for="name" class="block font-ui-label text-ui-label text-on-surface mb-2 font-semibold">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                    class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 font-metadata text-metadata text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm"
                    placeholder="e.g. Technology, Design, Philosophy" required>
            </div>

          

            <!-- Parent Category selection -->
            <div>
                <label for="parent_id" class="block font-ui-label text-ui-label text-on-surface mb-2 font-semibold">Parent Category</label>
                <div class="relative">
                    <select name="parent_id" id="parent_id"
                        class="w-full appearance-none bg-none bg-white border border-outline-variant rounded-xl px-4 py-3 font-metadata text-metadata text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer shadow-sm pr-10">
                        <option value="">None (Make it a root category)</option>
                        @foreach ($parent_categories as $parent)
                            <option value="{{ $parent->id }}" @if (old('parent_id', $category->parent_id) == $parent->id) selected @endif>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Custom Arrow Caret -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-secondary">
                        <span class="material-symbols-outlined text-[20px]">keyboard_arrow_down</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block font-ui-label text-ui-label text-on-surface mb-2 font-semibold">Description</label>
                <textarea name="description" id="description" rows="5"
                    class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 font-metadata text-metadata text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm"
                    placeholder="Briefly describe what this taxonomy node represents... max 1000 characters.">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Actions Bar -->
            <div class="pt-6 border-t border-outline-variant flex items-center justify-end gap-4">
                <a href="{{ route('dashboard.categories.index') }}" 
                    class="px-6 py-3 border border-outline-variant rounded-lg font-ui-button text-ui-button text-secondary hover:bg-surface-container transition-all">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-primary text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button shadow-sm hover:opacity-90 active:scale-95 transition-all">
                    {{ isset($method) && $method === 'PUT' ? 'Update Category' : 'Create Category' }}
                </button>
            </div>
        </div>

        <!-- Sidebar Guidelines -->
        <div class="lg:col-span-4 space-y-8">
            <div class="border-l border-outline-variant pl-8 space-y-6">
                <div>
                    <h3 class="font-ui-label text-ui-label text-on-surface uppercase tracking-wider font-bold mb-3">Taxonomy Guide</h3>
                    <p class="font-metadata text-metadata text-on-surface-variant leading-relaxed">
                        Taxonomy defines how readers explore your intellectual output. Keep names clear and memorable. Avoid excessively specific categories; use tags for detailed topics.
                    </p>
                </div>
                <div>
                    <h3 class="font-ui-label text-ui-label text-on-surface uppercase tracking-wider font-bold mb-3">Slug Rules</h3>
                    <p class="font-metadata text-metadata text-on-surface-variant leading-relaxed">
                        Slugs determine the clean URL path. They are restricted to lowercase alphanumeric characters and hyphens. Leaving it blank will automatically generate a hyphenated format from the category name.
                    </p>
                </div>
            </div>
        </div>
    </div>
</form>
