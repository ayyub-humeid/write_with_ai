 <!-- TopNavBar -->
 <header class="fixed top-0 z-50 w-full bg-surface border-b border-outline-variant">
     <div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-16">
         <div class="flex items-center gap-8">
             <a class="font-display-lg-mobile text-display-lg-mobile font-bold text-on-surface" href="#">Ink
                 &amp; @yield('title', 'Write Ai')</a>
             <nav class="hidden md:flex items-center gap-6">
                 <a class="text-primary font-bold border-b-2 border-primary pb-1 font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                     href="#">Feed</a>
                 <a class="text-on-surface-variant font-medium font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                     href="#">Authors</a>
                 <a class="text-on-surface-variant font-medium font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                     href="#">Dashboard</a>
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
                 <button
                     class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all">
                     <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                 </button>
                 <button
                     class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all">
                     <span class="material-symbols-outlined" data-icon="bookmark">bookmark</span>
                 </button>
                 <button
                     class="ml-2 bg-primary-container text-on-primary px-6 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all">
                     Create Post
                 </button>
                 <div class="ml-2 w-8 h-8 rounded-full overflow-hidden border border-outline-variant">
                     <img alt="User Avatar" class="w-full h-full object-cover"
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzK4lqFrJCFdA1EXa9IV2QY0yicoPsRMbYZIPeIFI4M3WjDJS_GawbISHmPBNBITs0BpleutqRjcbI8Iq_C2F2--xVX98EdGYQn9ZPi9WLFmuYXf2uUjQ0qHj2nDd8GoiJ5EvAaTf2zzUF6P-WiP3SK4ql18K5Kz2-CU9Q4GUQiH_P9zh_Cx6FTp9rONYvavs0wKg7oMitLHuhrwEKoFveTvBm3cdWAhZSIboecNWEJGy49lHJOBy3XdxSV2kDVEQVw1p_WhBC5xrS" />
                 </div>
             </div>
         </div>
     </div>
 </header>
