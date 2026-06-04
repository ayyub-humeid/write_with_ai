@props(['posts' => []])
<div class="grid grid-cols-1 gap-12">
    <!-- Article 2 -->
    @foreach ($posts as $post)
        <x-app-post-card :post="$post" />
    @endforeach
</div>
