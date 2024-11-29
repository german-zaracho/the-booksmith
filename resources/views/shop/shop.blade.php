<?php

/** @var \App\Models\Book $books */
?>

<x-app>
    <x-slot:title>Shop</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">Shop</h1>

    <div class="flex flex-wrap justify-center gap-8 m-auto">

        @foreach($books as $book)

        <a href="{{ route('shop.detail', ['id' => $book->book_id]) }}"  class=" basis-full sm:basis-1/2 sm:max-w-[50%] md:basis-1/3 md:max-w-[33.33%] lg:basis-1/4 lg:max-w-[25%] xl:basis-1/5 xl:max-w-[20%] max-w-full  flex justify-center" >

            <div class="pt-4 rounded-md bg-[#e9dfcd] shadow-2xl ring-2 ring-black ring-opacity-10 w-56 my-2.5 justify-center items-center px-6 py-4 flex flex-col">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($book->image) }}" alt="img" title="img" class="h-56 w-40 object-cover">
                <h4 class="mt-8 border-b-2">{{$book->title}}</h4>
                <div class="mb-10 text-center capitalize">{{$book->genre->name}}</div>
            </div>

        </a>

        @endforeach

    </div>


</x-app>
<!-- basis-1/5 max-w-[17%] -->