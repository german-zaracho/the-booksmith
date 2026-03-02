<?php
/** @var \Illuminate\Support\Collection $history */
?>

<x-app>
    <x-slot:title>Order History</x-slot:title>

    <div class="max-w-4xl mx-auto px-4 py-10 min-h-screen">
        <h1 class="text-3xl font-bold mb-8 text-center">Order History</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($history->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-xl font-semibold">No orders yet</p>
                <p class="mt-2 text-sm">Your completed purchases will appear here.</p>
                <a href="{{ route('shop') }}" class="mt-6 bg-[#f09224] text-white px-6 py-2 rounded-lg hover:bg-[#fcba50] transition font-medium">
                    Go to Shop
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($history as $buy)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

                        {{-- Order header --}}
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Order #{{ $buy->buy_id }}</p>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    {{ \Carbon\Carbon::parse($buy->date)->format('F j, Y') }}
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">

                                {{-- Payment method badge --}}
                                @php
                                    $pm = $buy->payment_method ?? 'mercadopago';
                                @endphp
                                @if($pm === 'credit_card')
                                    <span class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1 rounded-full border bg-gray-100 text-gray-700 border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Credit Card
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1 rounded-full border bg-blue-50 text-blue-700 border-blue-200">
                                        <svg width="12" height="12" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="24" cy="24" r="24" fill="#009ee3"/>
                                            <path d="M24 12C17.373 12 12 17.373 12 24C12 30.627 17.373 36 24 36C30.627 36 36 30.627 36 24C36 17.373 30.627 12 24 12Z" fill="white"/>
                                            <path d="M30 21C30 24.314 27.314 27 24 27C20.686 27 18 24.314 18 21C18 17.686 20.686 15 24 15C27.314 15 30 17.686 30 21Z" fill="#009ee3"/>
                                        </svg>
                                        MercadoPago
                                    </span>
                                @endif

                                {{-- Status badge --}}
                                @php
                                    $statusColor = match(strtolower($buy->status_name ?? '')) {
                                        'completed'         => 'bg-green-100 text-green-700 border-green-300',
                                        'pending'           => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                        'canceled','failed' => 'bg-red-100 text-red-700 border-red-300',
                                        'shiped','shipped'  => 'bg-purple-100 text-purple-700 border-purple-300',
                                        default             => 'bg-gray-100 text-gray-600 border-gray-300',
                                    };
                                @endphp
                                <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $statusColor }}">
                                    {{ ucfirst($buy->status_name ?? 'Unknown') }}
                                </span>

                                <p class="text-lg font-bold text-[#f09224]">
                                    ${{ number_format($buy->total_price, 2) }}
                                </p>
                            </div>
                        </div>

                        {{-- Order items --}}
                        <div class="divide-y divide-gray-100">
                            @foreach($buy->items as $item)
                                <div class="px-6 py-4 flex items-center gap-4">
                                    @if(!empty($item->image) && file_exists(public_path('storage/books/' . $item->image)))
                                        <img src="{{ asset('storage/books/' . $item->image) }}" class="w-10 h-14 object-cover rounded shadow flex-shrink-0">
                                    @else
                                        <img src="{{ asset('assets/imgs/no-image.jpg') }}" class="w-10 h-14 object-cover rounded shadow flex-shrink-0">
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800 text-sm">{{ $item->title ?? 'Unknown Book' }}</p>
                                        <p class="text-gray-500 text-xs">{{ $item->author ?? '' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                        <p class="text-sm font-semibold text-gray-700">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('cart') }}" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-sm font-medium">
                    Back to Cart
                </a>
                <a href="{{ route('shop') }}" class="px-6 py-2 rounded-lg bg-[#f09224] text-white hover:bg-[#fcba50] transition text-sm font-medium">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

</x-app>