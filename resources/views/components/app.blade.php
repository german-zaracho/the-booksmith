<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="<?= asset('assets/imgs/logo.ico'); ?>" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/menu.js', 'resources/js/slider.js', 'resources/css/slider.css', 'resources/css/home_cards.css', 'resources/css/reviews.css', 'resources/js/reviews.js'])
    <title>{{ $title ?? ''}} :: The Booksmith</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />

    <style>
        /* ── Toast ─────────────────────────────────────────────── */
        #toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #1a1a1a;
            color: #fff;
            padding: 0.875rem 1.25rem;
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            border-left: 4px solid #f09224;
            min-width: 260px;
            max-width: 360px;
            transform: translateY(120%);
            opacity: 0;
            transition: transform 0.35s cubic-bezier(.34,1.56,.64,1), opacity 0.3s ease;
        }
        #toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        #toast .toast-icon {
            width: 2rem;
            height: 2rem;
            background: #f09224;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        #toast .toast-text { font-size: 0.875rem; line-height: 1.4; }
        #toast .toast-title { font-weight: 700; font-size: 0.8rem; color: #f09224; margin-bottom: 2px; letter-spacing: 0.05em; text-transform: uppercase; }
    </style>
</head>

<body class="bg-[#f09224] max-w-[2000px] mx-auto">

    {{-- ── Toast notification ─────────────────────────────── --}}
    @if(session('cart_added'))
    <div id="toast">
        <div class="toast-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div class="toast-text">
            <p class="toast-title">Added to cart</p>
            <p style="color:#d1d5db;font-size:0.8rem;">{{ Str::limit(session('cart_added'), 40) }}</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var t = document.getElementById('toast');
            if (t) {
                setTimeout(function () { t.classList.add('show'); }, 100);
                setTimeout(function () { t.classList.remove('show'); }, 3500);
            }
        });
    </script>
    @endif

    <div class="bg-[#faf7f2]">

        <nav class="bg-brown-gradient">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-row justify-between">
                <div class="flex h-16 items-center justify-between w-[100%]">

                    <!-- Logo + Nav links -->
                    <div class="flex items-center">
                        <div class="flex flex-row flex-shrink-0 items-center text-center">
                            <a href="{{ route('welcome') }}" class="flex flex-row flex-shrink-0 items-center text-center rounded-md px-3 py-2 text-sm myBtn text-white" aria-current="page">
                                <img class="h-10 w-10 mr-3.5" src="{{ asset('assets/imgs/logo.ico') }}" alt="The Booksmith">
                                <h1 class="myh1 hidden lg:block">The Booksmith</h1>
                            </a>
                        </div>
                        <div class="hidden lg:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="{{ route('welcome') }}" class="rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-black hover:bg-[#fcba50] hover:text-white pt-[6px]" aria-current="page">Home</a>
                                <a href="{{ route('news') }}" class="rounded-md {{ request()->routeIs('news') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-black hover:bg-[#fcba50] hover:text-white">News</a>
                                <a href="{{ route('shop') }}" class="rounded-md {{ request()->routeIs('shop') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-black hover:bg-[#fcba50] hover:text-white">Shop</a>
                                <a href="{{ route('subscriptions') }}" class="rounded-md {{ request()->routeIs('subscriptions') ? 'bg-[#f09224]' :''}} px-3 py-2 text-sm myBtn text-black hover:bg-[#fcba50] hover:text-white">Subscriptions</a>
                            </div>
                        </div>
                    </div>

                    @if (Route::has('login'))
                    <div class="-mx-3 flex justify-end items-center">
                        @auth
                        @php
                            $user = Auth::user();
                            // Cart badge count
                            $cartCount = \Illuminate\Support\Facades\DB::table('orders_has_users')
                                ->where('orders_has_users.user_fk', $user->user_id)
                                ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
                                ->whereNull('order_books.buy_fk')
                                ->count();
                        @endphp

                        @if($user->role_id == 1)
                        <div class="hidden lg:flex lg:flex-row">
                            <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-sm myBtn text-black hover:bg-[#fcba50] hover:text-white">
                                Dashboard
                            </a>
                        </div>
                        @endif

                        {{-- Cart icon with badge --}}
                        <div class="hidden lg:flex relative h-9 w-9 rounded-full hover:bg-[#fcba50] bg-[#f09224] hover:text-white ml-4 cursor-pointer items-center justify-center">
                            <a href="{{ route('cart') }}" class="flex items-center justify-center w-full h-full">
                                <span class="material-symbols-outlined" style="font-size:20px;">shopping_cart</span>
                            </a>
                            <span id="cart-badge"
                                  class="absolute -top-1 -right-1 bg-white text-[#f09224] text-[10px] font-black leading-none w-4 h-4 rounded-full flex items-center justify-center shadow border border-[#f09224]"
                                  style="min-width:16px; {{ $cartCount === 0 ? 'display:none;' : '' }}">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        </div>

                        <!-- Profile dropdown -->
                        <div class="hidden lg:block ml-4">
                            <div class="relative ml-3">
                                <div class="user-myProfile-button">
                                    <button type="button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="absolute -inset-1.5"></span>
                                        @if($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/profilePhoto/' . $user->img) }}" alt="Profile">
                                        @else
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('assets/imgs/user.png') }}" alt="Profile">
                                        @endif
                                    </button>
                                </div>

                                <!-- Dropdown -->
                                <div class="user-myProfile-menu absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @else
                        {{-- Guest --}}
                        <div class="hidden lg:flex space-x-2">
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Log in</a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Register</a>
                            @endif
                        </div>
                        @endauth
                    </div>
                    @endif

                    <!-- Hamburger -->
                    <div class="-mr-2 flex lg:hidden h-[40px] mt-[10px]">
                        <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-[#f09224] p-2 text-gray-400 hover:bg-[#fcba50] hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="mobile-menu-button">
                            <span class="absolute -inset-0.5"></span>
                            <svg id="menu-open-icon" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                            <svg id="menu-close-icon" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden hidden bg-[#f09224] shadow-2xl ring-2 ring-black ring-opacity-10 border-t-0" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 sm:px-3 text-center">
                    <a href="{{ route('welcome') }}" class="block rounded-md {{ request()->routeIs('welcome') ? 'bg-[#ab550f]' :''}} px-3 py-2 text-base myBtn text-white hover:bg-[#fcba50]">Home</a>
                    <a href="{{ route('news') }}" class="block rounded-md {{ request()->routeIs('news') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">News</a>
                    <a href="{{ route('shop') }}" class="block rounded-md {{ request()->routeIs('shop') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Shop</a>
                    <a href="{{ route('subscriptions') }}" class="block rounded-md {{ request()->routeIs('subscriptions') ? 'bg-[#f09224]' :''}} px-3 py-2 text-base myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Subscriptions</a>
                </div>

                @if (Route::has('login'))
                @auth
                @php $user = $user ?? Auth::user(); @endphp
                @if($user->role_id == 1)
                <a href="{{ url('/dashboard') }}" class="rounded-md flex justify-center mb-3 mr-3 ml-3 px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Dashboard</a>
                @endif

                <a href="{{ url('/cart') }}" class="rounded-md flex justify-center items-center gap-2 mb-3 mr-3 ml-3 px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">
                    <span class="material-symbols-outlined" style="font-size:20px;">shopping_cart</span>
                    @php $cartCountMobile = $cartCount ?? 0; @endphp
                    <span id="cart-badge-mobile"
                          class="bg-white text-[#f09224] text-xs font-bold px-1.5 py-0.5 rounded-full"
                          style="{{ $cartCountMobile === 0 ? 'display:none;' : '' }}">
                        {{ $cartCountMobile }}
                    </span>
                </a>

                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center justify-center px-5">
                        <div class="flex-shrink-0">
                            @if($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))
                                <img src="{{ asset('storage/profilePhoto/' . $user->img) }}" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                            @else
                                <img src="{{ asset('assets/imgs/user.png') }}" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                            @endif
                        </div>
                        <div class="ml-3">
                            <div class="text-base myBtn leading-none text-white">{{ $user->name }}</div>
                            <div class="text-sm myBtn leading-none text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1 px-2 flex flex-col items-center justify-center w-[100%]">
                        <a href="{{ route('profile') }}" class="w-[100%] text-center block rounded-md px-3 py-2 text-base myBtn text-gray-400 hover:bg-[#fcba50] hover:text-white">Your Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-[100%]">
                            @csrf
                            <button type="submit" class="w-[100%] text-center block rounded-md px-3 py-2 text-base myBtn text-gray-400 hover:bg-[#fcba50] hover:text-white cursor-pointer">Log Out</button>
                        </form>
                    </div>
                </div>

                @else
                <div class="flex flex-col text-center mb-3">
                    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-sm myBtn text-gray-300 hover:bg-[#fcba50] hover:text-white">Register</a>
                    @endif
                </div>
                @endauth
                @endif
            </div>

        </nav>

        {{ $slot }}

        <footer class="bg-gray-900 text-white">
            <div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="flex justify-center text-teal-600">
                    <img class="h-10 w-10" src="{{ asset('assets/imgs/logo.ico') }}" alt="The Booksmith logo">
                </div>
                <p class="mx-auto mt-6 max-w-md text-center leading-relaxed text-gray-500">
                    The Booksmith is your destination for literary exploration and discovery.
                </p>
                <nav class="mt-12 flex flex-wrap justify-center gap-6 md:gap-8">
                    <a class="text-gray-500 transition hover:text-gray-400 hover:opacity-75 text-sm" href="{{ route('welcome') }}">Home</a>
                    <a class="text-gray-500 transition hover:text-gray-400 hover:opacity-75 text-sm" href="{{ route('news') }}">News</a>
                    <a class="text-gray-500 transition hover:text-gray-400 hover:opacity-75 text-sm" href="{{ route('shop') }}">Shop</a>
                    <a class="text-gray-500 transition hover:text-gray-400 hover:opacity-75 text-sm" href="{{ route('subscriptions') }}">Subscriptions</a>
                </nav>
                <ul class="mt-12 flex flex-wrap justify-center gap-6 md:gap-8">
                    <li>
                        <a href="#" rel="noreferrer" target="_blank" class="text-gray-500 transition hover:text-gray-400 hover:opacity-75">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" rel="noreferrer" target="_blank" class="text-gray-500 transition hover:text-gray-400 hover:opacity-75">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <p class="mt-12 text-center text-sm text-gray-500">&copy; {{ date('Y') }} The Booksmith. All rights reserved.</p>
            </div>
        </footer>
    </div>
    <script>
        // Profile dropdown toggle
        const menuButton = document.getElementById('user-menu-button');
        const menuDropdown = document.querySelector('.user-myProfile-menu');

        if (menuButton && menuDropdown) {
            menuButton.addEventListener('click', function (e) {
                e.stopPropagation();
                menuDropdown.classList.toggle('hidden');
            });

            // Close when clicking outside
            document.addEventListener('click', function () {
                menuDropdown.classList.add('hidden');
            });

            menuDropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    </script>
</body>

</html>