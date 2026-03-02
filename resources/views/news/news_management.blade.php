<?php

/** @var \App\Models\News $news */ ?>

<x-app>
    <x-slot:title>News Management</x-slot:title>

    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-5xl mx-auto">

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
                        <h1 class="text-2xl font-bold text-gray-900">News Management</h1>
                        <p class="text-sm text-gray-500">{{ $news->count() }} articles</p>
                    </div>
                </div>
                <a href="{{ route('news.create') }}"
                    class="inline-flex items-center gap-2 bg-[#f09224] hover:bg-[#fcba50] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Article
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
                            <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Article</th>
                            <th class="py-3 px-5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($news as $new)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-[#e9dfcd] flex-shrink-0">
                                        @if($new->img && file_exists(public_path('storage/news/' . $new->img)))
                                        <img src="{{ asset('storage/news/' . $new->img) }}" class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#c8b99a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $new->title }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('news.detail', ['id' => $new->news_id]) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                        View
                                    </a>
                                    <a href="{{ route('news.edit', ['id' => $new->news_id]) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                        Edit
                                    </a>
                                    <a href="{{ route('news.delete', ['id' => $new->news_id]) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-700 hover:bg-red-100 transition">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="py-12 text-center text-gray-400 text-sm">No articles yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app>