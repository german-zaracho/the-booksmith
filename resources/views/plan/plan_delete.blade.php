<?php

/** @var \App\Models\BookPlan $plans */
?>

<x-app>
    <x-slot:title>Plan Details</x-slot:title>

    <div class="m-[30px] flex flex-col justify-center items-center">
        <h1>Name: "{{ $plans->name }}"</h1>
        <p class="mt-4">Description: "{{ $plans->description }}"</p>
        <p class="mt-4">Price: "{{ $plans->total_price }}"</p>

        <form action="{{ route('plan.destroy', ['id' => $plans->book_plan_id]) }}" method="post" class="mt-4">
            @csrf
            @method('DELETE')
            <button class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">Yes, delete</button>
        </form>
    </div>

</x-app>