@props(['posts' => []])
<div class="space-y-4">
    <!-- Row 1 -->
    @foreach ($posts as $post)
        <x-dashboard.posts.post-card-compnent :post="$post" />
    @endforeach

</div>
