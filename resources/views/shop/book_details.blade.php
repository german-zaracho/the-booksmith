<x-app>
    <x-slot:title>{{ $books->title }}</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-5xl mx-auto">

            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('shop') }}" class="hover:text-[#f09224] transition">Shop</a>
                <span>/</span>
                <span class="text-gray-700 font-medium truncate max-w-[200px]">{{ $books->title }}</span>
            </nav>

            <div class="bg-white rounded-3xl shadow-sm border border-[#ede8dd] overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    <div class="md:w-64 lg:w-80 flex-shrink-0 bg-[#e9dfcd] flex items-center justify-center p-10">
                        @if($books->image && file_exists(public_path('storage/books/' . $books->image)))
                            <img src="{{ asset('storage/books/' . $books->image) }}"
                                 alt="{{ $books->title }}"
                                 class="w-48 h-auto object-cover rounded-xl shadow-lg">
                        @else
                            <div class="w-48 h-64 bg-[#d5c8b0] rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#a89678]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 p-8 flex flex-col">

                        <span class="inline-flex self-start items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 capitalize mb-3">
                            {{ $books->genre->name }}
                        </span>

                        <h1 class="text-3xl font-black text-gray-900 leading-tight mb-1">{{ $books->title }}</h1>
                        <p class="text-gray-500 text-sm mb-6">
                            by <span class="font-semibold text-gray-700">{{ $books->author }}</span>
                            &middot; {{ $books->editorial }}
                        </p>

                        <div class="bg-[#faf7f2] rounded-2xl p-5 mb-6 border border-[#ede8dd]">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-2">Synopsis</p>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $books->synopsis }}</p>
                        </div>

                        <div class="flex items-center gap-6 mt-auto">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Price</p>
                                <p class="text-3xl font-black text-[#f09224]">${{ $books->price }}</p>
                            </div>

                            @auth
                                <form id="addToCartForm"
                                      method="POST"
                                      action="{{ route('cart.add', ['bookId' => $books->book_id]) }}"
                                      class="flex-1">
                                    @csrf
                                    <button id="addToCartBtn"
                                            type="submit"
                                            class="w-full bg-gray-900 hover:bg-[#f09224] text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                                        <svg id="cartSpinner" class="hidden animate-spin h-5 w-5 text-white flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        <svg id="cartIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span id="cartBtnText">Add to Cart</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl transition text-sm flex items-center justify-center gap-2">
                                    Log in to buy
                                </a>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>

            @auth
                @if(Auth::user()->role_id == 1)
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('shop.management') }}"
                           class="text-sm text-gray-400 hover:text-[#f09224] transition">
                            &larr; Back to Shop Management
                        </a>
                    </div>
                @endif
            @endauth

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form    = document.getElementById('addToCartForm');
            var btn     = document.getElementById('addToCartBtn');
            var spinner = document.getElementById('cartSpinner');
            var icon    = document.getElementById('cartIcon');
            var btnText = document.getElementById('cartBtnText');

            if (form && btn) {
                form.addEventListener('submit', function () {
                    spinner.classList.remove('hidden');
                    icon.classList.add('hidden');
                    btnText.textContent = 'Adding...';
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                });
            }
        });
    </script>

</x-app>