<?php

/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var \App\Models\News $news */

?>

<x-app>
    <x-slot:title>News edit</x-slot:title>
    <div class="m-[30px] flex flex-col justify-center items-center">
        <h1>[Editing "{{ $news->title }}"]</h1>

        @if($errors->any())
        <div>The information entered contains errors, please try again.</div>
        @endif

        <form action="{{ route('news.update', ['id' => $news->news_id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">

                    <div class="sm:col-span-4 py-1.5 mt-3">
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                        <div class="mt-2">
                            <input id="title" name="title" type="text" autocomplete="title" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6
                    @error('title') border-red-500 ring-red-500 @enderror
                    "
                                @error('title') aria-invalid="true" aria-errormessage="error-title" @enderror
                                value="{{ old('title', $news->title)}}">
                        </div>
                        @error('title')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="col-span-full ">
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" class="block w-full max-w-[1200px] lg:min-w-[800px] rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6
                        @error('description') border-red-500 ring-red-500 @enderror
                        "
                                    @error('description') aria-invalid="true" aria-errormessage="error-description" @enderror>{{old('description', $news->description)}}</textarea>
                            </div>
                            @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="col-span-full mt-3 ">
                        <label for="img" class="block text-sm font-medium leading-6 text-gray-900">Image</label>
                        <div class="mt-2 flex justify-between w-full max-w-[1200px] rounded-lg border border-dashed border-gray-900/25 px-6 py-10">

                            <div class="max-h-[220px] max-w-[160px]">
                                <p class="mb-[10px]">Current image</p>
                                @if($news->img && \Illuminate\Support\Facades\Storage::has($news->img))
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($news->img) }}" alt="card-image" class="object-cover w-full h-full rounded-[20px]" />
                                @else
                                <img src="{{ asset('assets/imgs/no-image.jpg') }}" alt="card-image" class="object-cover w-full h-full" />
                                @endif
                            </div>


                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex items-center text-sm leading-6 text-gray-600">

                                    <label for="img" class="relative flex items-center justify-center cursor-pointer w-[150px] h-[40px] rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="img" name="img" type="file" class="sr-only">
                                    </label>

                                    <p class="pl-1 mt-4">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <div class="flex justify-end mt-3">
                <button class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300 ">Apply changes</button>
            </div>

        </form>
    </div>


</x-app>