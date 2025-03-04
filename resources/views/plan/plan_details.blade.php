<?php

/** @var \App\Models\BookPlan $plans */
?>

<x-app>
    <x-slot:title>Plan Details</x-slot:title>

    <div class="mx-auto my-[30px] p-[30px] max-w-[800px] flex flex-col justify-center items-center rounded-[20px]  shadow-2xl ring-2 ring-black ring-opacity-10">
        <h1>{{ $plans->name }}</h1>
        <p class="text-black mt-4 max-w-[600px]">[Description]: {{ $plans->description }}</p>
        <p class="text-black mt-4 max-w-[600px]">[Price]: $ {{ $plans->total_price }}</p>
    </div>
    @auth
        @if (Auth::check() && Auth::user()->role_id == 1)
            <div class="flex justify-end mt-3 mr-[15%]">
                <a href="{{ route('plan.management') }}" class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300">
                    Go to Plan Management
                </a>
            </div>
        @endif
    @endauth


</x-app>