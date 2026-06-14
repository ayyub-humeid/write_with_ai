 @props([
     'author' => [
         'name' => 'Sarah Drasner',
         'username' => '@sarahdrasner',
         'bio' => 'Software Engineer',
         'image' =>
             'https://lh3.googleusercontent.com/aida-public/AB6AXuB_bDNza0_XsizBBXy317LgL0ZlmEMBGHRNKyKJQEHUTZshyhzuRibQZzQeQZzBZYYQiReJ2d-IiJwtoIjp6M6rGrrwY37laL6K4BthiktNmgwhd0qebRtgpHmf8yFhbk-tHrPmUa7BNZsDbuhL6IgYwEAUf_kGkv_NiAdgkdMoXonaLJXpkAtuWiOU1uM4o9ZxZjLoB4P657GWFnuaJ4zwrnfXzPwxL1DmQ-hiP1T0i5Tr4yNY1JUGm0wgGbbwqoDe_zItDbBhPO9s',
         'followers' => 123456789,
     ],
 ])
 <div class="flex items-center justify-between">
     <div class="flex items-center gap-3">
         <img alt="User" class="w-10 h-10 rounded-full object-cover" src="{{ $author->gravatar_url }}" />
         <div>
             <p class="font-ui-label text-ui-label font-bold text-on-surface">{{ $author->name }}</p>
             <p class="font-metadata text-metadata text-secondary">{{ $author->bio }}</p>
         </div>
     </div>
     <button id="follow-btn-{{ $author->id }}" data-author-id="{{ $author->id }}"
         onclick="@if (Auth::check() && Auth::user()->followings->contains($author->id)) unfollow({{ $author->id }}) @else follow({{ $author->id }}) @endif"
         class="px-3 py-1 border border-on-surface text-on-surface rounded-full font-metadata text-metadata font-bold hover:bg-on-surface hover:text-white transition-all">{{ Auth::check() && Auth::user()->followings->contains($author->id) ? 'Unfollow' : 'Follow' }}</button>
 </div>
