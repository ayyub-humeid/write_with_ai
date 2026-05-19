@props(['categories' => []])

<div class="overflow-x-auto bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm w-full">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-surface-container-low border-b border-outline-variant">
                <th class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">Category Name</th>
                <th class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">Post Count</th>
                <th class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider">Total Views</th>
                <th class="px-6 py-4 font-ui-label text-ui-label font-bold text-on-surface uppercase tracking-wider text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant">
            @foreach($categories as $category)
                <x-dashboard.categories.category-row :category="$category" />
            @endforeach
        </tbody>
    </table>
</div>
