<?php

/** @var \App\Models\News $news */
?>

<x-app>
    <x-slot:title>News Management</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">News Management</h1>

    <div class="m-[30px]">
        <div class="flex justify-end mt-3">
            <a href="{{ route('news.create') }}" class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300">+ Create news</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300 w-full mt-3 rounded-[20px] overflow-hidden">
                <thead>
                    <tr>
                        <th class="w-[70%] border border-gray-300 p-4 text-left bg-gray-200">Title</th>
                        <th class="w-[30%] border border-gray-300 p-4 text-left bg-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $new)
                    <tr class="bg-white">
                        <td class="border border-gray-300 p-4">{{$new->title}}</td>
                        <td class="border border-gray-300 p-4">
                            <div class="w-[450px] flex flex-col md:flex-row justify-between items-end md:space-x-4 space-x-0 space-y-2 max-768:max-w-[200px] max-768:items-center">
                                <a href="{{ route('news.detail', ['id' => $new->news_id]) }}" class="w-full h-[40px] max-768:max-w-[150px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Read more
                                </a>

                                <a href="{{ route('news.edit', ['id' => $new->news_id]) }}" class="w-full h-[40px] max-768:max-w-[150px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-400 dark:hover:bg-orange-500 dark:focus:ring-orange-600">
                                    Edit
                                </a>

                                <a href="{{ route('news.delete', ['id' => $new->news_id]) }}" class="w-full h-[40px] max-768:max-w-[150px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>



</x-app>