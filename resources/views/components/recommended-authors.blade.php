<div class="space-y-6">
    <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Recommended
        Authors</h3>
    <div class="space-y-4">
        @foreach ($authors as $author)
                    <x-author-card :author="$author" />
                @endforeach
            </div>
            <a class="block font-ui-label text-ui-label text-primary font-bold hover:underline" href="#">View
                all recommendations</a>
        </div>