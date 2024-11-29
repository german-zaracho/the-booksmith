<x-app>
    <x-slot:title>News details</x-slot:title>
    <div class="m-[30px] flex flex-col justify-center items-center">
        <h1>{{ $news->title }}</h1>
        <img src="{{ \Illuminate\Support\Facades\Storage::url($news->img) }}" alt="img" title="img" class="object-cover h-[200px] w-40 rounded-[20px] mt-4">
        <p class="text-black mt-4 max-w-[600px]">[Description]: {{ $news->description }}</p>
    </div>
</x-app>