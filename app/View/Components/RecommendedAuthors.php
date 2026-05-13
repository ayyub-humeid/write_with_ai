<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecommendedAuthors extends Component
{
    /**
     * Create a new component instance.
     */
    public $authors = [
        [
            'name' => 'Sarah Drasner',
            'username' => '@sarahdrasner',
            'bio' => 'Software Engineer',
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_bDNza0_XsizBBXy317LgL0ZlmEMBGHRNKyKJQEHUTZshyhzuRibQZzQeQZzBZYYQiReJ2d-IiJwtoIjp6M6rGrrwY37laL6K4BthiktNmgwhd0qebRtgpHmf8yFhbk-tHrPmUa7BNZsDbuhL6IgYwEAUf_kGkv_NiAdgkdMoXonaLJXpkAtuWiOU1uM4o9ZxZjLoB4P657GWFnuaJ4zwrnfXzPwxL1DmQ-hiP1T0i5Tr4yNY1JUGm0wgGbbwqoDe_zItDbBhPO9s',
            'followers' => 12400,
            'isFollowing' => false,
        ],
        [
            'name' => 'David Perell',
            'username' => '@david_perell',
            'bio' => 'Writer & Educator',
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEbvciYQ2X_kcFKWWe0O2L03yycemd88WyF_ooBIPwvG-WUezMyveSVstWiBM3XBuBVeVDzlceL-_gL4AgUIr6BEBpg3Euz2S2UzZN3b7J0xsam1LeGO1NhpU_0esyYJLMpFBq04g-yrbxML5Mh9hqxz5h5TIJ9P7mJfg6g-cWjvM7qDXLTdmFZBp2k_85lHK2C98M3j3TVo-8bN-Fxw0iZjBGwnUEnXJTIzcuZiKkPQIYxNt5ft8vlUeIg_jxv3WpCbfdLVr_BibE',
            'followers' => 85000,
            'isFollowing' => false,
        ],
        [
            'name' => 'Alice Wong',
            'username' => '@disabilityvis',
            'bio' => 'Ethics in Tech',
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBn451ZfbDr0Yg1IXraoXumBVLm-GRjvj1ID8YSBo0NiOHTR4h-nTwkze6WtbjRnNOOMDcBV7PVYIEX2ErQLZ5CS0pjQHCWUfvRmnxBdvz8-Vx2EBwEKvXbfHCqrNa1VTMg8U0jzBuUI677uzcLVYBXfX-MGBuqjb8F88PuUlDth4sZu3gUuA2PIYmrVS-QFLFolBrLmvCbiZ1MixmBXlkAL8-XnIM-WJuv7SMkmfwFvY9i6LBBcJEWfjZDfTG8AOPKgzwjZMRCMCdJ',
            'followers' => 32000,
            'isFollowing' => false,
        ],
        [
            'name' => 'Julian Thorne',
            'username' => '@jthorne_design',
            'bio' => 'Design Principal',
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDlYHQ2yPKl-Weyq3JRVjhy936Wd9AaAVvFRAHsIQrKrnCv4i5A-cQ6YF0zqrKz1Ma7N9cW9R6NimpSIUyDmkSyzdN0Sf4wwyS7Jf5Iq_UrWBpwB9MPN5QGbUNdxa82Mz2YU2I0GnXGjM6DDPi-mIODcm-LUOTsZb-C7V1GgUyP3AvuztsY0A5OKbR2TsqCVVxpF70-TiHMB2Jsyd2ojVnbA0gj9jJ03QY9BqD7puDZnBBYI5PyKBtwtQiGWMcknmNIjCWUWokSAMSR',
            'followers' => 15700,
            'isFollowing' => false,
        ],
    ];
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recommended-authors');
    }
}
