<?php

/** @var \App\Models\News $news */
?>

<x-app>
    <x-slot:title>News Management</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">News Management</h1>
    <p class="mb-3"><a href="{{ route('news.create') }}">+ Create news</a></p>
    @foreach($news as $new)

    <div class="max-w-[1080px] my-2.5 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-black dark:border-gray-700">
        <div class="flex justify-between items-center space-x-[30px]">
            <div class="myNews flex space-x-4">
                <h2 class="mb-2 flex items-center font-sans text-2xl antialiased font-semibold leading-snug tracking-normal text-white">
                    {{$new->title}}
                </h2>
            </div>

            <div class="w-[450px] flex justify-between space-x-4">

                <a href="{{ route('news.detail', ['id' => $new->news_id]) }}" class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                </a>

                <a href="{{ route('news.edit', ['id' => $new->news_id]) }}" class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-400 dark:hover:bg-orange-500 dark:focus:ring-orange-600">
                    Edit
                </a>

                <a href="{{ route('news.delete', ['id' => $new->news_id]) }}" class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                    Delete
                </a>
            </div>
        </div>
    </div>

    @endforeach

</x-app>