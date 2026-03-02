<?php /** @var \App\Models\News $news */ ?>

<x-app>
    <x-slot:title>News</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-4xl mx-auto">

            {{-- Header --}}
            <div class="flex items-end justify-between mb-10 border-b border-[#e8dfc8] pb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-1">The Booksmith</p>
                    <h1 class="text-4xl font-black text-gray-900 leading-tight">Latest News</h1>
                    <p class="text-gray-500 mt-1 text-sm">{{ $news->count() }} articles</p>
                </div>
                @auth
                    @if(Auth::user()->role_id == 1)
                        <a href="{{ route('news.create') }}"
                           class="inline-flex items-center gap-2 bg-gray-900 hover:bg-[#f09224] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New Article
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Articles list --}}
            <div class="space-y-5">
                @foreach($news as $new)
                <a href="{{ route('news.detail', ['id' => $new->news_id]) }}"
                   class="group flex items-start gap-5 bg-white rounded-2xl border border-[#ede8dd] shadow-sm hover:shadow-md hover:border-[#f09224] transition-all duration-200 p-5 hover:-translate-y-0.5">

                    {{-- Thumbnail --}}
                    <div class="flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden bg-[#e9dfcd]">
                        @if($new->img && file_exists(public_path('storage/news/' . $new->img)))
                            <img src="{{ asset('storage/news/' . $new->img) }}"
                                 alt="{{ $new->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#c8b99a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base font-bold text-gray-900 group-hover:text-[#f09224] transition-colors leading-snug mb-2">
                            {{ $new->title }}
                        </h2>
                        <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                            {{ $new->description }}
                        </p>
                    </div>

                    {{-- Arrow --}}
                    <div class="flex-shrink-0 self-center">
                        <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#f09224] flex items-center justify-center transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>

                </a>
                @endforeach
            </div>

        </div>
    </div>

</x-app>