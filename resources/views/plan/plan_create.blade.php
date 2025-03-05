<?php

/** @var \App\Models\BookPlan $plans */
?>

<x-app>
    <x-slot:title>Plan Creation</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">Plan Creation</h1>

    <div class="m-[30px] flex flex-col justify-center items-center">

        <form action="{{ route('plan.store') }}" method="post">
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">

                    <div class="sm:col-span-4 py-1.5">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <input id="name" name="name" type="text" autocomplete="name" class="block w-96 max-w-full max-620:w-auto rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[black] sm:text-sm sm:leading-6
                        @error('name') border-red-500 ring-red-500 @enderror
                        "
                                @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror
                                value="{{ old('name')}}">
                        </div>
                        @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="col-span-full">
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" class="block w-full max-w-[1200px] lg:min-w-[800px] rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[black] sm:text-sm sm:leading-6
                            @error('description') border-red-500 ring-red-500 @enderror
                            "
                                    @error('description') aria-invalid="true" aria-errormessage="error-description" @enderror>{{old('description')}}</textarea>
                            </div>
                            @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="col-span-full">
                            <label for="total_price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                            <div class="mt-2">
                                <input id="total_price" name="total_price" type="text" autocomplete="total_price" class="block w-96 max-w-full max-620:w-auto rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[black] sm:text-sm sm:leading-6
                        @error('total_price') border-red-500 ring-red-500 @enderror
                        "
                                    @error('total_price') aria-invalid="true" aria-errormessage="error-total_price" @enderror
                                    value="{{ old('total_price')}}">
                            </div>
                            @error('total_price')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>

            </div>

            <div class="flex justify-end max-620:justify-center mt-11">
                <button class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300">Save</button>
            </div>
        </form>
    </div>

</x-app>