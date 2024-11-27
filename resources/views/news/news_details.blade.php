<x-app>
    <x-slot:title>News details</x-slot:title>
    <div class="text-center">
        <h2 class="tryColor">Hello details!</h2>
        <h1>{{ $news->title }}</h1>
        <img src="{{ asset('assets/imgs/news/' . $news->img) }}" alt="img" title="img" class="object-cover h-[200px] w-40">
        <p class="text-black">Description: {{ $news->description }}</p>
    </div>
</x-app>