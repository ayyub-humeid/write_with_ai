# Categories Architecture & Core Code Summary

This document outlines the core code blocks and design decisions implemented for the Category Management system.

---

## 1. Database Relations (`app/Models/Category.php`)
We configured mass assignment rules and recursive self-referential relationships to manage infinite parent-child category nestings:

```php
protected $fillable = ['name', 'slug', 'description', 'parent_id'];

/**
 * Get the parent category node.
 */
public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

/**
 * Get subcategory nodes.
 */
public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}
```

---

## 2. Live Counts & Deletion Router (`app/Http/Controllers/Dashboard/CategoryController.php`)
* **Dynamic Post Counter**: Eager-loads child relations and pre-calculates posts counts via Eloquent counts mapping (`withCount('posts')`).
* **Robust AJAX/Accept Headers Check**: Rather than returning simple redirects that confuse browser fetch engines under HTTP DELETE verbs, we detect client-side expectations:

```php
if ($request->ajax() || $request->wantsJson()) {
    return response()->json([
        'success' => true,
        'message' => 'Category deleted successfully.',
        'count'   => Category::count()
    ]);
}
```

---

## 3. Modular View Framework (`resources/views/components/dashboard/categories/`)
We separated category listings into four specialized sub-views:
1. **`category-component`**: Main bento grid shell. Isolates the highest-priority category to display as the large bento card and handles blank index fallbacks.
2. **`category-card`**: Singular grid block component with an `:isLarge` condition to determine dimensions, metadata layouts, and stats overlays.
3. **`category-table`**: Houses taxonomy tables and structures column headers.
4. **`category-row`**: Singular item listing within index grids, linking actions and counts.

---

## 4. Client-side Real-time Search Filter (`index.blade.php`)
Equipped the index view with vanilla JS listening loops targeting keyups inside `#category-search`. It instantly parses the DOM of bento elements and table rows, matching against names and slugs to hide non-matching items without sending database request loops:

```javascript
const query = e.target.value.toLowerCase().trim();

// 1. Filter Bento Cards
document.querySelectorAll('[id^="category-card-"]').forEach(card => {
    const titleText = card.querySelector('h2')?.textContent.toLowerCase() || '';
    card.style.display = titleText.includes(query) ? '' : 'none';
});

// 2. Filter Table Rows
document.querySelectorAll('[id^="category-row-"]').forEach(row => {
    const titleText = row.querySelector('.font-headline-md')?.textContent.toLowerCase() || '';
    row.style.display = titleText.includes(query) ? '' : 'none';
});
```
