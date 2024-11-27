<x-app>
    <x-slot:title>Book details</x-slot:title>
    <!-- <h2 class="tryColor">Hello details!</h2> -->
    <h1>{{ $books->title }}</h1>
    <img src="{{ asset('assets/imgs/books/' . $books->image) }}" alt="img" title="img" class="h-56 w-40 object-cover">
    <p class="text-black">Author: {{ $books->author }}</p>
    <p class="text-black">Description: {{ $books->synopsis }}</p>
    <button class="bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition duration-300">Buy</button>
</x-app>