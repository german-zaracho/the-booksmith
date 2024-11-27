<?php

/** @var \Illuminate\Support\ViewErrorBag $errors */
?>

<x-app>
    <x-slot:title>New Book</x-slot:title>
    <h2 class="tryColor">Hello new book!</h2>
    @if($errors->any())
    <div>The information entered contains errors, please try again.</div>
    @endif

    <form action="{{ route('shop.store') }}" method="post">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <div class="sm:col-span-4 py-1.5">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                    <div class="mt-2">
                        <input id="title" name="title" type="text" autocomplete="title" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                        @error('title') border-red-500 ring-red-500 @enderror
                        "
                            @error('title') aria-invalid="true" aria-errormessage="error-title" @enderror
                            value="{{ old('title')}}">
                    </div>
                    <!-- @if($errors->has('title'))
                    <div>{{ $errors->first('title')}}</div>
                    @endif -->
                    @error('title')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="col-span-full">
                        <label for="synopsis" class="block text-sm font-medium leading-6 text-gray-900">Synopsis</label>
                        <div class="mt-2">
                            <textarea id="synopsis" name="synopsis" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                            @error('synopsis') border-red-500 ring-red-500 @enderror
                            "
                                @error('synopsis') aria-invalid="true" aria-errormessage="error-synopsis" @enderror>{{old('synopsis')}}</textarea>
                        </div>
                        @error('synopsis')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="sm:col-span-4 py-1.5">
                    <label for="editorial" class="block text-sm font-medium leading-6 text-gray-900">Editorial</label>
                    <div class="mt-2">
                        <input id="editorial" name="editorial" type="text" autocomplete="editorial" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                        @error('editorial') border-red-500 ring-red-500 @enderror
                        "
                            @error('editorial') aria-invalid="true" aria-errormessage="error-editorial" @enderror
                            value="{{ old('editorial')}}"
                            >
                    </div>
                    @error('editorial')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sm:col-span-4 py-1.5">
                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                    <div class="mt-2">
                        <input id="price" name="price" type="text" autocomplete="price" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                        @error('price') border-red-500 ring-red-500 @enderror
                        "
                            @error('price') aria-invalid="true" aria-errormessage="error-price" @enderror
                            value="{{ old('price')}}"
                            >
                    </div>
                    @error('price')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-span-full">
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Front page image</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                <label for="image" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="image" name="image" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-b border-gray-900/10 pb-12">

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="sm:col-span-4 py-1.5">
                        <label for="author" class="block text-sm font-medium leading-6 text-gray-900">Author</label>
                        <div class="mt-2">
                            <input id="author" name="author" type="text" autocomplete="author" class="block w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                            @error('author') border-red-500 ring-red-500 @enderror
                            "
                                @error('author') aria-invalid="true" aria-errormessage="error-author" @enderror
                                value="{{ old('author')}}"
                                >
                        </div>
                        @error('author')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="genre_fk" class="block text-sm font-medium leading-6 text-gray-900">Genre</label>
                        <div class="mt-2">
                            <select id="genre_fk" name="genre_fk" autocomplete="genre" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option value="1">Terror</option>
                                <option value="2">Adventure</option>
                                <option value="3">Juvenile</option>
                                <option value="4">Warlike</option>
                                <option value="5">Romance</option>
                                <option value="6">Science fiction</option>
                                <option value="7">Fantasy</option>
                                <option value="8">Historic</option>
                                <option value="9">Thriller</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
        </div>
    </form>

</x-app>