<?php

/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var \App\Models\BookPlan $plans */

?>

<x-app>
    <x-slot:title>Plan Edition</x-slot:title>
    <div class="m-[30px] flex flex-col justify-center items-center">
        <h1>[Editing "{{ $plans->name }}"]</h1>

        <form action="{{ route('plan.update', ['id' => $plans->book_plan_id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">

                    <div class="sm:col-span-4 py-1.5 mt-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Plan Name</label>
                        <div class="mt-2">
                            <input id="name" name="name" type="text" autocomplete="name" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('name') border-red-500 ring-red-500 @enderror" value="{{ old('name', $plans->name) }}">
                        </div>
                        @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" class="block w-full max-w-[1200px] lg:min-w-[800px] rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('description') border-red-500 ring-red-500 @enderror">{{ old('description', $plans->description) }}</textarea>
                            </div>
                            @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-4 py-1.5 mt-3">
                        <label for="total_price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                        <div class="mt-2">
                            <input id="total_price" name="total_price" type="number" step="0.01" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('total_price') border-red-500 ring-red-500 @enderror" value="{{ old('total_price', $plans->total_price) }}">
                        </div>
                        @error('total_price')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="flex justify-end mt-3">
                <button class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300"
                type="submit">Apply changes</button>
            </div>
        </form>
    </div>
</x-app>
