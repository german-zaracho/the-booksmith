<?php

/** @var \App\Models\News $news */
?>

<x-app>
    <x-slot:title>News details</x-slot:title>
    <h2 class="tryColor">Hello details!</h2>
    <h1>Title: "{{ $news->title }}"</h1>
    <img src="{{ asset('assets/imgs/news/' . $news->img) }}" alt="img" title="img" class="h-56 w-40 object-cover">
    <p>Description: "{{ $news->description }}"</p>

    <form action="{{ route('news.destroy', ['id' => $news->news_id]) }}"
        method="post">
        @csrf
        @method('DELETE')
        <button class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">Yes, delete</button>
    </form>

</x-app>