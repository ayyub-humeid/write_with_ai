 <!-- TopNavBar -->
 <header class="fixed top-0 z-50 w-full bg-surface border-b border-outline-variant">
     <div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-16">
         <div class="flex items-center gap-8">
             <a class="font-display-lg-mobile text-display-lg-mobile font-bold text-on-surface" href="#">Ink
                 &amp; Write AI</a>
             <nav class="hidden md:flex items-center gap-6">
                 <a class="{{ request()->routeIs('posts.index') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-medium hover:text-primary' }} font-ui-label text-ui-label transition-colors duration-200"
                     href="{{ route('posts.index') }}">Feed</a>
                 <a class="{{ request()->routeIs('dashboard.posts.*') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-medium hover:text-primary' }} font-ui-label text-ui-label transition-colors duration-200"
                     href="{{ route('dashboard.posts.index') }}">Manage Posts</a>
                 <a class="{{ request()->routeIs('dashboard.categories.*') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-medium hover:text-primary' }} font-ui-label text-ui-label transition-colors duration-200"
                     href="{{ route('dashboard.categories.index') }}">Manage Categories</a>
             </nav>
         </div>
         <div class="flex items-center gap-4">
             <div
                 class="hidden lg:flex items-center bg-surface-container border border-outline-variant rounded-full px-4 py-1.5 gap-2">
                 <span class="material-symbols-outlined text-secondary" data-icon="search">search</span>
                 <input class="bg-transparent border-none focus:ring-0 text-ui-label font-ui-label w-48"
                     placeholder="Search..." type="text" />
             </div>
             <div class="flex items-center gap-2">
                 <a href="{{ route('dashboard.notifications.index') }}"
                     class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all relative">
                     <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                     <span id="notification-badge"
                        class="absolute top-0 right-0 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-primary rounded-full border-2 border-surface {{ (auth()->check() && auth()->user()->unreadNotifications->count() > 0) ? '' : 'hidden' }}">
                        {{ auth()->check() ? auth()->user()->unreadNotifications->count() : '0' }}
                    </span>
                 </a>
                 <button
                     class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all">
                     <span class="material-symbols-outlined" data-icon="bookmark">bookmark</span>
                 </button>
                 <x-user-menu-component />
             </div>
         </div>
     </div>
 </header>
