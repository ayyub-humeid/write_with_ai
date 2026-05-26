@auth
    <div class="flex items-center  space-x-4">
        <a href="{{ route('dashboard.posts.create') }}"
            class="ml-2 bg-primary-container text-on-primary px-6 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all">
            Create Post
        </a>

        <div class="relative ml-2" id="user-menu-wrapper">
            <button onclick="toggleMenu()"
                class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary-container transition-all">
                <img alt="User Avatar" class="w-full h-full object-cover"
                    src="@if (auth()->user()->avatar) {{ asset('storage/' . auth()->user()->avatar) }} @else {{ auth()->user()->gravatar_url }} @endif" />
            </button>

            <div id="dropdown-menu"
                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-outline-variant py-2 z-50 animate-fade-in">
                <div class="px-4 py-2 border-b border-outline-variant">
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>

                <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                    Settings
                </a>

                <hr class="border-outline-variant my-1">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-right block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const wrapper = document.getElementById('user-menu-wrapper');
            const menu = document.getElementById('dropdown-menu');
            if (wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
@endauth

@guest
    <div>
        <a href="{{ route('login') }}"
            class="ml-2 bg-primary-container text-on-primary px-4 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all">
            Login
        </a>
        <a href="{{ route('register') }}"
            class="ml-2 bg-purple-500 text-on-secondary px-4 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all">
            Register
        </a>
    </div>


@endguest
