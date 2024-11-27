<nav class="bg-brown-gradient">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            <!-- NavBar options -->
            <div class="flex items-center">
                <div class="flex flex-row flex-shrink-0 items-center text-center">
                    <img class="h-10 w-10 mr-3.5" src="{{ asset('assets/imgs/logo.ico') }}" alt="The Booksmith">
                    <h1 class="myh1">The Booksmith</h1>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">

                        <a href="{{ route('welcome') }}" class="rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-white  hover:bg-[#fcba50] hover:text-white" aria-current="page">Home</a>
                        <a href="{{ route('news') }}" class="rounded-md {{ request()->routeIs('news') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News</a>
                        <!-- @if (Auth::check() && Auth::user()->role_id == 1)
                        <a href="{{ route('news.management') }}" class="rounded-md {{ request()->routeIs('news.management') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News Management</a>
                        <a href="{{ route('admin.users') }}" class="rounded-md {{ request()->routeIs('admin.users') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Users</a>
                        @endif -->
                        <a href="{{ route('shop') }}" class="rounded-md {{ request()->routeIs('shop') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Shop</a>
                        <a href="{{ route('subscriptions') }}" class="rounded-md  {{ request()->routeIs('subscriptions') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Subscriptions</a>

                    </div>


                </div>
            </div>

            @if (Route::has('login'))
            <div class="-mx-3 flex flex-1 justify-end">
                @auth
                @if (Auth::check() && Auth::user()->role_id == 1)
                <a
                    href="{{ url('/dashboard') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Dashboard
                </a>
                @endif

                <!-- My Profile -->
                <div class="hidden md:block">

                    <div class="ml-4 flex items-center md:ml-6">

                        <!-- Profile dropdown -->
                        <div class="relative ml-3">

                            <div class="user-myProfile-button">
                                <button type="button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('assets/imgs/anakin-skywalker.webp') }}" alt="">
                                </button>
                            </div>

                            <div class="md:hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a :href="route('logout')"
                                        class="block px-4 py-2 text-sm text-gray-700 cursor-pointer" role="menuitem" tabindex="-1" id="user-menu-item-2"
                                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                @else
                <a
                    href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Log in
                </a>

                @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Register
                </a>
                @endif
                @endauth
            </div>
            @endif



            <!-- Hamburger menu -->
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-[#f09224] p-2 text-gray-400 hover:bg-[#fcba50] hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="mobile-menu-button">
                    <span class="absolute -inset-0.5"></span>

                    <!-- Menu open icon -->
                    <svg id="menu-open-icon" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                    <!-- Menu close icon -->
                    <svg id="menu-close-icon" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>

    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden hidden" id="mobile-menu">

        <!-- NavBar Options -->
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="{{ route('welcome') }}" class="block rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-white hover:bg-[#fcba50]" aria-current="page">Home</a>
            <a href="{{ route('news') }}" class="block rounded-md {{ request()->routeIs('news') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News</a>
            <!-- @if (Auth::check() && Auth::user()->role_id == 1)
            <a href="{{ route('news.management') }}" class="block rounded-md {{ request()->routeIs('news.management') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News Management</a>
            <a href="{{ route('admin.users') }}" class="block rounded-md {{ request()->routeIs('admin.users') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Users</a>
            @endif -->
            <a href="{{ route('shop') }}" class="block rounded-md {{ request()->routeIs('shop') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Shop</a>
            <a href="{{ route('subscriptions') }}" class="block rounded-md {{ request()->routeIs('subscriptions') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Subscriptions</a>
        </div>


        @if (Route::has('login'))
        @auth
        @if (Auth::check() && Auth::user()->role_id == 1)
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Dashboard
        </a>
        @endif

        <!-- My Profile -->
        <div class="border-t border-gray-700 pb-3 pt-4">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ asset('assets/imgs/anakin-skywalker.webp') }}" alt="user image">
                </div>
                <div class="ml-3">
                    <div class="text-base myBtn leading-none text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm myBtn leading-none text-gray-400">{{ Auth::user()->email }}</div>
                </div>

            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-base myBtn text-gray-400 hover:bg-[#f09224] hover:text-white">Your Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a :href="route('logout')"
                        class="block rounded-md px-3 py-2 text-base myBtn text-gray-400 hover:bg-[#f09224] hover:text-white cursor-pointer" role="menuitem" tabindex="-1" id="user-menu-item-2"
                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>

        @else
        <a
            href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Log in
        </a>

        @if (Route::has('register'))
        <a
            href="{{ route('register') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Register
        </a>
        @endif
        @endauth
        @endif

    </div>

</nav>