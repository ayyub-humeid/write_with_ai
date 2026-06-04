@props(['post' => new App\Models\Post()])
<article class="flex flex-col md:flex-row gap-8 group">
    <div class="w-full md:w-1/3 aspect-video md:aspect-square overflow-hidden rounded-lg border border-outline-variant">
        <img alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            data-alt="A close-up shot of a classic fountain pen resting on an open notebook filled with elegant handwriting. The scene is lit by warm, natural afternoon sunlight coming through a nearby window, creating long, soft shadows. The paper has a subtle grain, and the ink appears rich and saturated, embodying an atmosphere of intellectual focus and traditional craftsmanship."
            src="{{ $post->thumbnail_url }}" />
    </div>
    <div class="w-full md:w-2/3 space-y-3">
        <div class="flex items-center gap-2 font-metadata text-metadata text-secondary">
            <span class="text-primary font-bold">{{ $post->category->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at->format('M j, Y') }}</span>
        </div>
        <h3 class="font-headline-md text-[24px] leading-snug text-on-surface group-hover:text-primary transition-colors">
            <a href="{{ route('posts.show', $post->slug) }}" class="text-on-surface group-hover:text-primary">
                {{ $post->title }}
            </a>
        </h3>
        <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2">How modern
            high-resolution displays are bringing back the elegance of the serif, and why readability is
            the new luxury.</p>
        <div class="flex items-center gap-3 pt-2">
            <p class="font-ui-label text-ui-label text-on-surface font-medium">{{ $post->user->name }}</p>
            <span class="text-secondary text-metadata">•</span>
            <span class="text-secondary font-metadata text-metadata">5 min read</span>
        </div>
    </div>
</article>
