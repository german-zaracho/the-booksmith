<?php

/** @var \App\Models\Book $books */ ?>

<x-app>
    <x-slot:title>Shop</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="flex items-end justify-between mb-10 border-b border-[#e8dfc8] pb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-1">The Booksmith</p>
                    <h1 class="text-4xl font-black text-gray-900 leading-tight">Our Collection</h1>
                    <p class="text-gray-500 mt-1 text-sm">{{ $books->count() }} books available</p>
                </div>
                @auth
                @if(Auth::user()->role_id == 1)
                <a href="{{ route('shop.create') }}"
                    class="inline-flex items-center gap-2 bg-gray-900 hover:bg-[#f09224] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Book
                </a>
                @endif
                @endauth
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($books as $book)
                <a href="{{ route('shop.detail', ['id' => $book->book_id]) }}"
                    class="group flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-[#ede8dd] hover:border-[#f09224] transition-all duration-300 hover:-translate-y-1">

                    {{-- Book cover --}}
                    <div class="relative overflow-hidden bg-[#e9dfcd] aspect-[2/3]">
                        @if($book->image && file_exists(public_path('storage/books/' . $book->image)))
                        <img src="{{ asset('storage/books/' . $book->image) }}"
                            alt="{{ $book->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#c8b99a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        @endif
                        {{-- Genre badge --}}
                        <span class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full capitalize">
                            {{ $book->genre->name }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="p-3 flex flex-col flex-1">
                        <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-2 group-hover:text-[#f09224] transition-colors">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-400 mt-1 truncate">{{ $book->author }}</p>
                        <div class="mt-auto pt-3 flex items-center justify-between">
                            <span class="text-base font-black text-[#f09224]">${{ $book->price }}</span>
                            <span class="text-xs text-gray-400 group-hover:text-gray-600 transition">View →</span>
                        </div>
                    </div>

                </a>
                @endforeach
            </div>

        </div>
    </div>

</x-app>