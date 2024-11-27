<x-app>
    <x-slot:title>Checkout</x-slot:title>

    <h1 class="text-3xl font-bold text-center mb-8">Checkout</h1>

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 text-black">{{ $book_plan->name }}</h2>
        <p class="mb-6 text-black">{{ $book_plan->description }}</p>
        <p class="text-4xl font-bold mb-6">
            <span class="text-black">${{ $book_plan->total_price }}</span>
            <span class="text-xl font-normal text-gray-600 text-black">/month</span>
        </p>

        <form action="{{ route('checkout', $book_plan->book_plan_id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition duration-300">
                Finalize Subscription
            </button>
        </form>
    </div>
</x-app>