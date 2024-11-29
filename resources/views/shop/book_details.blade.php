<x-app>
    <x-slot:title>Book details</x-slot:title>

    <div class="mx-auto my-[30px] p-[30px] max-w-[800px] flex flex-col items-center rounded-[20px] shadow-2xl ring-2 ring-black ring-opacity-10">
        <h1>{{ $books->title }}</h1>
        <img src="{{ \Illuminate\Support\Facades\Storage::url($books->image) }}" alt="img" title="img" class="h-56 w-40 object-cover rounded-[20px] mt-3">
        <p class="text-black mt-3">Author: {{ $books->author }}</p>
        <p class="text-black mt-3 max-w-[600px]">Synopsis: {{ $books->synopsis }}</p>
        <p>Price: ${{ number_format($books->price * 100, 2) }}</p>

        <button class="mt-3 bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition duration-300 w-[100px]">Buy</button>
    </div>

</x-app>