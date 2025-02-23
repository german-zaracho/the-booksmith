<?php

/** @var \App\Models\News $news */
?>

<x-app>
    <x-slot:title>News</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">News</h1>
    <div class="mx-auto max-w-[1080px]">
    @auth
        @if (Auth::check() && Auth::user()->role_id == 1)
            <div class="flex justify-end mt-3 mr-[1%]">
                <a href="{{ route('news.create') }}" class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300">
                + Create news
                </a>
            </div>
        @endif
    @endauth

        @foreach($news as $new)
        <div class="my-2.5 p-6 bg-[#f09224] rounded-lg mb-[20px] mx-[1%] shadow-2xl ring-2 ring-black ring-opacity-10">
            <div class="flex justify-between items-center space-x-[30px] bg-[#f09224]">
                <div class="myNews flex space-x-4 bg-[#f09224]">
                    <div class="w-[120px] h-[120px] overflow-hidden rounded-md flex-shrink-0">
                        @if($new->img && \Illuminate\Support\Facades\Storage::has($new->img))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($new->img) }}" alt="card-image" class="object-cover w-full h-full" />
                        @else
                        <img src="{{ asset('assets/imgs/no-image.jpg') }}" alt="card-image" class="object-cover w-full h-full" />
                        @endif
                    </div>
                    <h2 class="mb-2 flex items-center font-sans text-lg font-semibold text-blue-gray-900">
                        {{$new->title}}
                    </h2>
                </div>
                <a href="{{ route('news.detail', ['id' => $new->news_id]) }}" class="w-[150px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
        @endforeach

    </div>

</x-app>