<?php

/** @var \App\Models\Book $books */
?>

<x-app>
    <x-slot:title>Shop</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">Shop</h1>

    @auth
    @if (Auth::check() && Auth::user()->role_id == 1)
    <div class="flex justify-end mt-3 mr-[1%]">
        <a href="{{ route('shop.create') }}" class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300">
            + New Book
        </a>
    </div>
    @endif
    @endauth

    <div class="flex flex-wrap justify-center gap-8 m-auto">

        @foreach($books as $book)

        <a href="{{ route('shop.detail', ['id' => $book->book_id]) }}" class=" basis-full sm:basis-1/2 sm:max-w-[50%] md:basis-1/3 md:max-w-[33.33%] lg:basis-1/4 lg:max-w-[25%] xl:basis-1/5 xl:max-w-[20%] max-w-full  flex justify-center">

            <div class="pt-4 rounded-md bg-[#e9dfcd] shadow-2xl ring-2 ring-black ring-opacity-10 w-56 my-2.5 justify-center items-center px-6 py-4 flex flex-col">
                @if($book->image && file_exists(public_path('storage/books/' . $book->image)))
                <img src="{{ asset('storage/books/' . $book->image) }}" alt="img" title="img" class="h-56 w-40 object-cover">
                @else
                <img src="{{ asset('assets/imgs/no-image.jpg') }}" alt="card-image" class="object-cover w-full h-full" />
                @endif
                <h4 class="mt-8 border-b-2">{{$book->title}}</h4>
                <div class="mb-10 text-center capitalize">{{$book->genre->name}}</div>
            </div>

        </a>

        @endforeach

    </div>


</x-app>
<!-- basis-1/5 max-w-[17%] -->