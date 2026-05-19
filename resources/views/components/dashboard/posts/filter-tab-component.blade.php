@props(['status', 'posts', 'status_options'])
 <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-outline-variant gap-4">
     <div class="flex gap-8 overflow-x-auto no-scrollbar">

         @foreach ($status_options as $option)
             <a href="{{ route('dashboard.posts.index', ['status' => strtolower($option['name'])]) }}"
                 data-status="{{ strtolower($option['name']) }}"
                 class="tab-link {{ $status == strtolower($option['name']) ? 'border-b-2 border-primary text-primary' : '' }} pb-4 text-ui-label font-bold whitespace-nowrap">
                 {{ $option['name'] }}
                 (<span id="count-{{ strtolower($option['name']) }}">{{ $option['count'] }}</span>)
             </a>
         @endforeach

     </div>
     <div class="flex items-center gap-2 pb-2">
         <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
             <span class="material-symbols-outlined" data-icon="filter_list">filter_list</span>
         </button>
         <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
             <span class="material-symbols-outlined" data-icon="sort">sort</span>
         </button>
     </div>
 </div>
