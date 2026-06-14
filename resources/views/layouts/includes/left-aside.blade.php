 <aside class="hidden md:block md:col-span-2 space-y-8">
     <div class="space-y-4">
         <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Discover</h3>
         <ul class="space-y-2">

             <li>
                 <a class="flex items-center gap-3 font-ui-label text-ui-label py-1 transition-colors {{ request('filter', 'explore') == 'explore' ? 'text-primary font-bold [.material-symbols-outlined_&]:[font-variation-settings:\'FILL\'_1]' : 'text-on-surface-variant hover:text-primary' }}"
                     href="{{ request()->fullUrlWithQuery(['filter' => 'explore']) }}">
                     <span class="material-symbols-outlined">explore</span>
                     Explore
                 </a>
             </li>

             <li>
                 <a class="flex items-center gap-3 font-ui-label text-ui-label py-1 transition-colors {{ request('filter') == 'popular' ? 'text-primary font-bold [.material-symbols-outlined_&]:[font-variation-settings:\'FILL\'_1]' : 'text-on-surface-variant hover:text-primary' }}"
                     href="{{ request()->fullUrlWithQuery(['filter' => 'popular']) }}">
                     <span class="material-symbols-outlined">trending_up</span>
                     Popular
                 </a>
             </li>

             <li>
                 <a class="flex items-center gap-3 font-ui-label text-ui-label py-1 transition-colors {{ request('filter') == 'recent' ? 'text-primary font-bold [.material-symbols-outlined_&]:[font-variation-settings:\'FILL\'_1]' : 'text-on-surface-variant hover:text-primary' }}"
                     href="{{ request()->fullUrlWithQuery(['filter' => 'recent']) }}">
                     <span class="material-symbols-outlined">history</span>
                     Recent
                 </a>
             </li>

         </ul>
     </div>
     <div class="space-y-4">
         <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Your Tags
         </h3>
         <div class="flex flex-wrap gap-2">
             <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                 href="#">#Development</a>
             <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                 href="#">#DesignSystems</a>
             <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                 href="#">#Minimalism</a>
             <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                 href="#">#Typography</a>
             <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
                 href="#">#Future</a>
         </div>
     </div>
 </aside>
