<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecommendedAuthors extends Component
{
    /**
     * Create a new component instance.
     */
        public $authors;
    public function __construct()
    {
        $this->authors = User::withCount('followers')
            ->where('id', '!=', auth()->id())
            ->orderByDesc('followers_count')
            ->latest()
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recommended-authors');
    }
}
