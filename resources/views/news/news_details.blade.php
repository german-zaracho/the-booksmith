<x-app>
    <x-slot:title>{{ $news->title }}</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-3xl mx-auto">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('news') }}" class="hover:text-[#f09224] transition">News</a>
                <span>/</span>
                <span class="text-gray-700 font-medium truncate max-w-[240px]">{{ $news->title }}</span>
            </nav>

            {{-- Article card --}}
            <article class="bg-white rounded-3xl shadow-sm border border-[#ede8dd] overflow-hidden">

                {{-- Hero image --}}
                @if($news->img && file_exists(public_path('storage/news/' . $news->img)))
                <div class="w-full h-64 md:h-80 overflow-hidden bg-[#e9dfcd]">
                    <img src="{{ asset('storage/news/' . $news->img) }}"
                        alt="{{ $news->title }}"
                        class="w-full h-full object-cover">
                </div>
                @else
                <div class="w-full h-40 bg-[#e9dfcd] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#c8b99a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                    </svg>
                </div>
                @endif

                {{-- Content --}}
                <div class="p-8 md:p-10">
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-3">The Booksmith · News</p>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight mb-6">{{ $news->title }}</h1>

                    <div class="border-t border-[#ede8dd] pt-6">
                        <p class="text-gray-700 leading-relaxed text-base">{{ $news->description }}</p>
                    </div>
                </div>

            </article>

            {{-- Footer nav --}}
            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('news') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#f09224] transition font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to News
                </a>

                @auth
                @if(Auth::user()->role_id == 1)
                <a href="{{ route('news.management') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#f09224] transition">
                    News Management →
                </a>
                @endif
                @endauth
            </div>

        </div>
    </div>

</x-app>