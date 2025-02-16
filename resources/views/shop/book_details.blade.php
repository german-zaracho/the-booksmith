<x-app>
    <x-slot:title>Book details</x-slot:title>

    <div class="mx-auto my-[30px] p-[30px] max-w-[800px] flex flex-col items-center rounded-[20px] shadow-2xl ring-2 ring-black ring-opacity-10">
        <h1>{{ $books->title }}</h1>
        <img src="{{ \Illuminate\Support\Facades\Storage::url($books->image) }}" alt="img" title="img" class="h-56 w-40 object-cover rounded-[20px] mt-3">
        <p class="text-black mt-3">Author: {{ $books->author }}</p>
        <p class="text-black mt-3 max-w-[600px]">Synopsis: {{ $books->synopsis }}</p>
        <p class="text-black mt-3">Editorial: {{ $books->editorial }}</p>
        <p class="text-black mt-3">Genre: {{ $books->genre->name }}</p>
        <p>Price: ${{ number_format($books->price * 100, 2) }}</p>

        <button class="mt-3 bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition duration-300 w-[100px]">Buy</button>
    </div>

    @auth
        @if (Auth::check() && Auth::user()->role_id == 1)
            <div class="flex justify-end mt-3 mr-[15%]">
                <a href="{{ route('shop.management') }}" class="w-[130px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium hover:text-[#f09224] text-white hover:bg-white rounded-lg bg-black focus:ring-4 focus:outline-none focus:ring-orange-300">
                    Go to Shop Management
                </a>
            </div>
        @endif
    @endauth

</x-app>