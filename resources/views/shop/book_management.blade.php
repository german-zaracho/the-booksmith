<?php

/** @var \App\Models\Book $books */ ?>

<x-app>
    <x-slot:title>Shop Management</x-slot:title>

    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-6xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Shop Management</h1>
                        <p class="text-sm text-gray-500">{{ $books->count() }} books in catalog</p>
                    </div>
                </div>
                <a href="{{ route('shop.create') }}"
                    class="inline-flex items-center gap-2 bg-[#f09224] hover:bg-[#fcba50] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Book
                </a>
            </div>

            {{-- Feedback --}}
            @if(session('feedback.message'))
            <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
                {!! session('feedback.message') !!}
            </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Book</th>
                            <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Author</th>
                            <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Genre</th>
                            <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Price</th>
                            <th class="py-3 px-5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($books as $book)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-14 rounded-lg overflow-hidden bg-[#e9dfcd] flex-shrink-0">
                                        @if($book->image && file_exists(public_path('storage/books/' . $book->image)))
                                        <img src="{{ asset('storage/books/' . $book->image) }}" class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#c8b99a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $book->title }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5 text-gray-500 hidden sm:table-cell">{{ $book->author }}</td>
                            <td class="py-4 px-5 hidden md:table-cell">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700 capitalize">
                                    {{ $book->genre->name }}
                                </span>
                            </td>
                            <td class="py-4 px-5 font-bold text-[#f09224] hidden md:table-cell">${{ $book->price }}</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('shop.detail', ['id' => $book->book_id]) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                        View
                                    </a>
                                    <a href="{{ route('shop.edit', ['id' => $book->book_id]) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                        Edit
                                    </a>
                                    <a href="{{ route('shop.delete', ['id' => $book->book_id]) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-700 hover:bg-red-100 transition">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 text-sm">No books in the catalog yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app>