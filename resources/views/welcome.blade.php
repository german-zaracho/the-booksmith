<x-app>
    <x-slot:title>Home</x-slot:title>
    @if(session('success'))
    <div class="bg-green-500 text-white p-4 mb-4 rounded">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="bg-red-500 text-white p-4 mb-4 rounded">
        {{ session('error') }}
    </div>
    @endif
    <div class="text-center">
        <h1 class="text-center text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl mt-[50px] mb-[50px]">Welcome to The Booksmith</h1>
        <x-slider></x-slider>
        <x-home_cards></x-home_cards>
        <x-reviews></x-reviews>
    </div>
</x-app>