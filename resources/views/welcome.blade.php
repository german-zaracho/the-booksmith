<x-app>
    <x-slot:title>Home</x-slot:title>

    {{-- Hero section --}}
    <div class="bg-[#faf7f2]">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="max-w-4xl mx-auto px-4 pt-6">
            <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @elseif(session('error'))
        <div class="max-w-4xl mx-auto px-4 pt-6">
            <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        {{-- Hero header --}}
        <div class="text-center pt-14 pb-10 px-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-3">Welcome to</p>
            <h1 class="text-5xl sm:text-6xl font-black text-gray-900 leading-tight tracking-tight mb-4">
                The Booksmith
            </h1>
            <p class="text-gray-500 text-lg max-w-xl mx-auto leading-relaxed mb-8">
                Your destination for curated books, literary news, and monthly subscription boxes crafted for readers.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('shop') }}"
                    class="inline-flex items-center gap-2 bg-gray-900 hover:bg-[#f09224] text-white font-bold px-6 py-3 rounded-xl transition-all duration-200 text-sm">
                    Browse the Shop
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ route('subscriptions') }}"
                    class="inline-flex items-center gap-2 bg-[#f09224] hover:bg-[#fcba50] text-white font-bold px-6 py-3 rounded-xl transition-all duration-200 text-sm">
                    Explore Plans
                </a>
            </div>
        </div>

        {{-- Slider --}}
        <div class="px-4 pb-10">
            <x-slider></x-slider>
        </div>

        {{-- Stats strip --}}
        <div class="bg-white border-y border-[#ede8dd] py-8 px-4 mb-10">
            <div class="max-w-4xl mx-auto grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-3xl font-black text-[#f09224]">500+</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-1">Books available</p>
                </div>
                <div class="border-x border-[#ede8dd]">
                    <p class="text-3xl font-black text-[#f09224]">3</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-1">Subscription plans</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-[#f09224]">100%</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-1">Curated selections</p>
                </div>
            </div>
        </div>

        {{-- Featured cards --}}
        <div class="px-4 pb-10">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-6 px-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-1">Discover</p>
                        <h2 class="text-2xl font-black text-gray-900">What we offer</h2>
                    </div>
                </div>
                <x-home_cards></x-home_cards>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="bg-white border-y border-[#ede8dd] py-10 px-4 mb-10">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-0 px-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-1">Testimonials</p>
                        <h2 class="text-2xl font-black text-gray-900">What our readers say</h2>
                    </div>
                </div>
                <x-reviews></x-reviews>
            </div>
        </div>

        {{-- CTA banner --}}
        <div class="mx-4 mb-12 mt-10 bg-gray-900 rounded-3xl p-10 text-center">
            <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-3">Ready to start?</p>
            <h2 class="text-3xl font-black text-white mb-3">Get your first box today</h2>
            <p class="text-gray-400 text-sm mb-7 max-w-md mx-auto">Join thousands of readers who receive hand-picked books delivered to their door every month.</p>
            <a href="{{ route('subscriptions') }}"
                class="inline-flex items-center gap-2 bg-[#f09224] hover:bg-[#fcba50] text-white font-bold px-8 py-3.5 rounded-xl transition-all duration-200 text-sm">
                See subscription plans →
            </a>
        </div>

    </div>

</x-app>