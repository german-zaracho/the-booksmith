<?php

/** @var \App\Models\Plan $book_plans */
?>

<x-app>
    <x-slot:title>Subscriptions</x-slot:title>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif
    
    <h1 class="text-3xl font-bold text-center mb-8">Choose Your Plan</h1>

    <div class="flex flex-wrap gap-8 justify-center mx-auto max-w-7xl">

        @foreach($book_plans as $book_plan)

        <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/5">

            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col h-full">
                <h3 class="text-xl font-semibold mb-4">{{$book_plan->name}}</h3>
                <p class="text-black font-bold mb-12 h-[300px]">{{$book_plan->description}}</p>
                <!-- <p class="text-4xl font-bold mb-6">${{$book_plan->total_price}}<span class="text-xl font-normal text-gray-600">/month</span></p> -->
                <p class="text-4xl font-bold mb-6">
                    <span class="text-black">${{$book_plan->total_price}}</span>
                    <span class="text-xl font-normal text-gray-600">/month</span>
                </p>
                <ul class="mb-6 flex-grow">
                    <li class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        3 {{$book_plan->name}} books
                    </li>
                </ul>

                <form action="{{ route('subscribe', $book_plan->book_plan_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition duration-300">Subscribe</button>
                </form>

            </div>

        </div>

        @endforeach

    </div>

</x-app>