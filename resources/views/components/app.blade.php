<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="<?= asset('assets/imgs/logo.ico'); ?>" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/menu.js', 'resources/js/slider.js', 'resources/css/slider.css', 'resources/css/home_cards.css', 'resources/css/reviews.css', 'resources/js/reviews.js'])
    <title>{{ $title ?? ''}} :: The Booksmith</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>

<body class=" bg-[#f09224]">
    <div class=" bg-[#f09224]">

        <nav class="bg-brown-gradient">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-row justify-between">

                <div class="flex h-16 items-center justify-between w-[100%]">

                    <!-- NavBar options -->
                    <div class="flex items-center">
                        <div class="flex flex-row flex-shrink-0 items-center text-center">
                            <a href="{{ route('welcome') }}" class="flex flex-row flex-shrink-0 items-center text-center rounded-md px-3 py-2 text-sm myBtn text-white" aria-current="page">
                                <img class="h-10 w-10 mr-3.5" src="{{ asset('assets/imgs/logo.ico') }}" alt="The Booksmith">
                                <h1 class="myh1 hidden lg:block">The Booksmith</h1>
                            </a>

                        </div>
                        <div class="hidden lg:block">
                            <div class="ml-10 flex items-baseline space-x-4">

                                <a href="{{ route('welcome') }}" class="rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-white  hover:bg-[#fcba50] hover:text-white" aria-current="page">Home</a>
                                <a href="{{ route('news') }}" class="rounded-md {{ request()->routeIs('news') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News</a>
                                <a href="{{ route('shop') }}" class="rounded-md {{ request()->routeIs('shop') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Shop</a>
                                <a href="{{ route('subscriptions') }}" class="rounded-md  {{ request()->routeIs('subscriptions') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Subscriptions</a>

                            </div>

                        </div>
                    </div>

                    @if (Route::has('login'))
                    <div class="-mx-3 flex justify-end items-center">
                        @auth
                        @if (Auth::check() && Auth::user()->role_id == 1)
                        <div class="hidden lg:flex lg:flex-row">
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-md  {{ request()->routeIs('/dashboard') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                                Dashboard
                            </a>
                            @endif

                            <!-- My Profile -->
                            <div class="hidden lg:block">

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
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </a>
                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>



                        @else
                        <div class="hidden lg:block">
                            <a href="{{ route('login') }}"
                                class="rounded-md  {{ request()->routeIs('login') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                                Log in
                            </a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md  {{ request()->routeIs('register') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                                Register
                            </a>
                        </div>
                        @endif
                        @endauth
                    </div>
                    @endif

                    <!-- Hamburger menu -->
                    <div class="-mr-2 flex lg:hidden h-[40px] mt-[10px]">
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
            <div class="md:hidden hidden bg-[#f09224] shadow-2xl ring-2 ring-black ring-opacity-10 border-t-0" id="mobile-menu">

                <!-- NavBar Options -->
                <div class="space-y-1 px-2 pt-2 sm:px-3 text-center">

                    <a href="{{ route('welcome') }}" class="block rounded-md {{ request()->routeIs('welcome') ? 'bg-[#ab550f]' :''}} px-3 py-2 text-base myBtn text-white hover:bg-[#fcba50]" aria-current="page">Home</a>
                    <a href="{{ route('news') }}" class="block rounded-md {{ request()->routeIs('news') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News</a>
                    <a href="{{ route('shop') }}" class="block rounded-md {{ request()->routeIs('shop') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Shop</a>
                    <a href="{{ route('subscriptions') }}" class="block rounded-md {{ request()->routeIs('subscriptions') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Subscriptions</a>
                </div>


                @if (Route::has('login'))
                @auth
                @if (Auth::check() && Auth::user()->role_id == 1)
                <a
                    href="{{ url('/dashboard') }}"
                    class="rounded-md flex justify-center mb-3 mr-3 ml-3 {{ request()->routeIs('/dashboard') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                    Dashboard
                </a>
                @endif

                <!-- My Profile -->
                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center justify-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ asset('assets/imgs/anakin-skywalker.webp') }}" alt="user image">
                        </div>
                        <div class="ml-3">
                            <div class="text-base myBtn leading-none text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm myBtn leading-none text-gray-400">{{ Auth::user()->email }}</div>
                        </div>

                    </div>
                    <div class="mt-3 space-y-1 px-2 flex flex-col items-center justify-center w-[100%]">
                        <a href="{{ route('profile.edit') }}" class="w-[100%] text-center block rounded-md px-3 py-2 mr-3 ml-3 text-base myBtn text-gray-400 hover:bg-[#fcba50] hover:text-white">Your Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-[100%] mr-3 ml-3">
                            @csrf
                            <a :href="route('logout')"
                                class="w-[100%] text-center block rounded-md px-3 py-2  text-base myBtn text-gray-400 hover:bg-[#fcba50] hover:text-white cursor-pointer" role="menuitem" tabindex="-1" id="user-menu-item-2"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>

                @else
                <div class="flex flex-col text-center mb-3">
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md  {{ request()->routeIs('login') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                        Log in
                    </a>

                    @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md  {{ request()->routeIs('register') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                        Register
                    </a>
                </div>

                @endif
                @endauth
                @endif

            </div>

        </nav>

        <main class=" bg-[#f09224] min-h-[50vw]">
            {{ $slot }}
        </main>

        <footer class="bg-brown-gradient-invert rounded-t-[20px] ">
            <div class="max-w-screen-xl px-4 py-16 mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <div class="flex flex-col justify-center sm:justify-start items-center sm:flex-none">
                        <div class="flex flex-row items-center">
                            <img src="{{ asset('assets/imgs/logo.ico') }}" class="mr-5 h-6 sm:h-9" alt="logo" />
                            <p class="myh1">The Booksmith</p>
                        </div>

                        <p class="max-w-xs mt-4 text-sm text-gray-600">
                            Crafting the perfect reading experience.
                        </p>
                        <div class="flex mt-8 space-x-6 text-gray-600">
                            <a class="hover:opacity-75" href target="_blank" rel="noreferrer">
                                <span class="sr-only"> Facebook </span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clipRule="evenodd" />
                                </svg>
                            </a>
                            <a class="hover:opacity-75" href target="_blank" rel="noreferrer">
                                <span class="sr-only"> Instagram </span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clipRule="evenodd" />
                                </svg>
                            </a>
                            <a class="hover:opacity-75" href target="_blank" rel="noreferrer">
                                <span class="sr-only"> Twitter </span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a class="hover:opacity-75" href target="_blank" rel="noreferrer">
                                <span class="sr-only"> GitHub </span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clipRule="evenodd" />
                                </svg>
                            </a>
                            <a class="hover:opacity-75" href target="_blank" rel="noreferrer">
                                <span class="sr-only"> Dribbble </span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clipRule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-8 lg:col-span-2 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="flex flex-col text-center lg:text-left items-center lg:block">
                            <p class="font-medium">
                                Company
                            </p>
                            <nav class="flex flex-col mt-4 space-y-2 text-sm text-gray-500">
                                <a class="hover:opacity-75" href="#"> About Us </a>
                                <a class="hover:opacity-75" href="#"> Our Story </a>
                                <a class="hover:opacity-75" href="#"> Meet the Booksmith Team </a>
                                <a class="hover:opacity-75" href="#"> Join Our Community </a>
                            </nav>
                        </div>
                        <div class="flex flex-col text-center lg:text-left items-center lg:block">
                            <p class="font-medium">
                                Services
                            </p>
                            <nav class="flex flex-col mt-4 space-y-2 text-sm text-gray-500">
                                <a class="hover:opacity-75" href="#"> Monthly Book Subscription Plans </a>
                                <a class="hover:opacity-75" href="#"> Customized Book Selections </a>
                                <a class="hover:opacity-75" href="#"> Book Gift Packages </a>
                                <a class="hover:opacity-75" href="#"> Author Spotlights & Interviews </a>
                            </nav>
                        </div>
                        <div class="flex flex-col text-center lg:text-left items-center lg:block">
                            <p class="font-medium">
                                Helpful Links
                            </p>
                            <nav class="flex flex-col mt-4 space-y-2 text-sm text-gray-500">
                                <a class="hover:opacity-75" href> Contact </a>
                                <a class="hover:opacity-75" href> FAQs </a>
                                <a class="hover:opacity-75" href="#"> Customer Support </a>
                                <a class="hover:opacity-75" href="#"> Book Recommendations </a>
                            </nav>
                        </div>
                        <div class="flex flex-col justify-center text-center lg:text-left items-center lg:block">
                            <p class="font-medium">
                                Book News
                            </p>
                            <nav class="flex flex-col mt-4 space-y-2 text-sm text-gray-500">
                                <a class="hover:opacity-75" href="#"> Latest Book Releases </a>
                                <a class="hover:opacity-75" href="#"> Book Reviews & Recommendations </a>
                                <a class="hover:opacity-75" href="#"> Author Events & Signings </a>
                                <a class="hover:opacity-75" href="#"> Subscribe to Our Newsletter </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>