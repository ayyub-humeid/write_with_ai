
 @extends('layouts.main')
 
@section('content')
<section class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start mb-16">
<div class="md:col-span-3 flex justify-center md:justify-start">
<div class="relative">
<img class="w-48 h-48 rounded-xl border border-outline-variant object-cover bg-surface-container shadow-sm" src="{{ $profile->gravatar_url }}" alt="{{ $profile->name }}'s avatar"/>
</div>
</div>
<div class="md:col-span-6 space-y-6">
<div class="space-y-2">
<h1 class="font-display-lg text-display-lg text-on-surface">{{ $profile->name }}</h1>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
    {{ $profile->bio ?? "No bio available yet." }}
</p>
</div>
<div class="flex flex-wrap gap-8">
<div class="flex flex-col">
<span class="font-headline-md text-headline-md text-on-surface">{{ number_format($profile->followers_count) }}</span>
<span class="font-metadata text-metadata text-secondary">Followers</span>
</div>
<div class="flex flex-col">
<span class="font-headline-md text-headline-md text-on-surface">{{ number_format($profile->followings_count) }}</span>
<span class="font-metadata text-metadata text-secondary">Following</span>
</div>
<div class="flex flex-col">
<span class="font-headline-md text-headline-md text-on-surface">{{ number_format($profile->posts_count) }}</span>
<span class="font-metadata text-metadata text-secondary">Posts</span>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-3">
<a class="text-secondary hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="language">language</span>
</a>
<a class="text-secondary hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="alternate_email">alternate_email</span>
</a>
</div>
<div class="h-4 w-px bg-outline-variant mx-2"></div>
<span class="font-metadata text-metadata text-secondary flex items-center gap-1">
<span class="material-symbols-outlined text-[16px]" data-icon="location_on">location_on</span>
    {{ $profile->location ?? "Undisclosed" }}
</span>
</div>
</div>
<div class="md:col-span-3 flex md:justify-end">
    @auth
        @if(Auth::id() !== $profile->id)
            <button id="follow-btn-{{ $profile->id }}" 
                onclick="{{ Auth::user()->followings->contains($profile->id) ? "unfollow($profile->id)" : "follow($profile->id)" }}" 
                class="w-full md:w-auto bg-primary text-on-primary px-8 py-3 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all shadow-sm">
                {{ Auth::user()->followings->contains($profile->id) ? 'Unfollow' : 'Follow' }}
            </button>
        @else
            <a href="" class="w-full md:w-auto border border-outline text-on-surface px-8 py-3 rounded-lg font-ui-button text-ui-button hover:bg-surface-container transition-all text-center">
                Edit Profile
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="w-full md:w-auto bg-primary text-on-primary px-8 py-3 rounded-lg font-ui-button text-ui-button hover:opacity-90 transition-all text-center">
            Follow
        </a>
    @endauth
</div>
</section>
<div class="border-b border-outline-variant mb-12">
<div class="flex gap-10">
<button onclick="switchTab('articles')" id="tab-articles" class="tab-btn pb-4 border-b-2 border-primary text-on-surface font-bold font-ui-label text-ui-label">Articles</button>
<button onclick="switchTab('about')" id="tab-about" class="tab-btn pb-4 border-b-2 border-transparent text-secondary hover:text-on-surface transition-colors font-ui-label text-ui-label">About</button>
<button onclick="switchTab('bookmarks')" id="tab-bookmarks" class="tab-btn pb-4 border-b-2 border-transparent text-secondary hover:text-on-surface transition-colors font-ui-label text-ui-label">Bookmarks</button>
</div>
</div>
<div id="content-articles" class="tab-content">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
    @forelse($posts as $post)
        @if($loop->first)
        <article class="md:col-span-8 group border border-outline-variant rounded-xl overflow-hidden bg-surface-container-lowest transition-all hover:border-primary">
            <div class="flex flex-col md:flex-row h-full">
                <div class="md:w-1/2 overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $post->thumbnailUrl }}" alt="{{ $post->title }}"/>
                </div>
                <div class="md:w-1/2 p-8 flex flex-col justify-between">
                    <div class="space-y-4">
                        <span class="font-metadata text-metadata text-primary uppercase tracking-wider font-bold">{{ $post->category->name }}</span>
                        <h2 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant line-clamp-3">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                    </div>
                    <div class="mt-8 flex items-center justify-between">
                        <span class="font-metadata text-metadata text-secondary">{{ $post->created_at->format('M j, Y') }} · {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                        <span class="material-symbols-outlined text-primary">arrow_forward</span>
                    </div>
                </div>
            </div>
        </article>
        <div class="md:col-span-4 space-y-8">
            <div class="p-6 border border-outline-variant rounded-xl bg-surface-container-low">
                <h3 class="font-ui-label text-ui-label font-bold text-on-surface mb-4">Topic Expertise</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($profile->posts()->with('category')->get()->pluck('category.name')->unique() as $cat)
                    <span class="px-3 py-1 bg-surface-container-highest rounded-full font-metadata text-metadata text-on-surface-variant">{{ $cat }}</span>
                    @endforeach
                </div>
            </div>
            <div class="p-6 border border-outline-variant rounded-xl border-dashed">
                <p class="font-metadata text-metadata text-secondary italic">"The intersection of thought and digital design."</p>
            </div>
        </div>
        @else
        <article class="md:col-span-4 group border border-outline-variant rounded-xl overflow-hidden bg-surface-container-lowest transition-all hover:border-primary">
            <div class="h-48 overflow-hidden bg-surface-container">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $post->thumbnailUrl }}" alt="{{ $post->title }}"/>
            </div>
            <div class="p-6 space-y-3">
                <span class="font-metadata text-metadata text-secondary">{{ $post->category->name }}</span>
                <h3 class="font-ui-label text-ui-label font-bold text-on-surface group-hover:text-primary transition-colors">
                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                </h3>
                <p class="font-metadata text-metadata text-on-surface-variant line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 80) }}</p>
            </div>
        </article>
        @endif
    @empty
        <div class="md:col-span-12 p-12 text-center border border-dashed border-outline-variant rounded-xl">
            <p class="text-secondary">No articles published yet.</p>
        </div>
    @endforelse
    </div>
</div>

<div id="content-about" class="tab-content hidden animate-fade-in">
    <div class="max-w-2xl bg-surface-container-low p-8 rounded-xl border border-outline-variant">
        <h3 class="font-headline-sm text-headline-sm mb-6 text-on-surface">About {{ $profile->name }}</h3>
        <div class="font-body-md text-body-md text-on-surface-variant space-y-4">
            <p>{{ $profile->bio ?? "This author hasn't shared a detailed bio yet." }}</p>
            <div class="pt-6 border-t border-outline-variant mt-6 grid grid-cols-2 gap-6">
                <div>
                    <span class="block font-metadata text-metadata text-secondary mb-1">Location</span>
                    <span class="text-on-surface">{{ $profile->location ?? "Global" }}</span>
                </div>
                <div>
                    <span class="block font-metadata text-metadata text-secondary mb-1">Joined</span>
                    <span class="text-on-surface">{{ $profile->created_at->format('F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="content-bookmarks" class="tab-content hidden animate-fade-in">
    <div class="p-12 text-center border border-dashed border-outline-variant rounded-xl">
        <span class="material-symbols-outlined text-secondary text-4xl mb-4">bookmark</span>
        <p class="text-secondary">Bookmarks are private or none available.</p>
    </div>
</div>
</div>
@if($posts->hasPages())
<div class="mt-16 flex justify-center">
    {{ $posts->links() }}
</div>
@endif
@endsection


@section('bodyClass',"bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container")
@section('mainClass',"max-w-container-max mx-auto px-gutter py-[8rem]")
@section('title',$profile->name)

@section('script')
<script>
    function switchTab(tabId) {
        // Hide all tab content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active styling from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-primary', 'text-on-surface', 'font-bold');
            btn.classList.add('border-transparent', 'text-secondary');
        });
        
        // Show the active tab content
        document.getElementById(`content-${tabId}`).classList.remove('hidden');
        
        // Add active styling to the clicked tab button
        const activeTab = document.getElementById(`tab-${tabId}`);
        activeTab.classList.remove('border-transparent', 'text-secondary');
        activeTab.classList.add('border-primary', 'text-on-surface', 'font-bold');
    }
</script>
@endsection


