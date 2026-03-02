<x-app>
    <x-slot:title>My Cart</x-slot:title>

    <!-- Modal de confirmación de eliminación -->
    <div id="removeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Remove item?</h3>
                    <p class="text-sm text-gray-500">This will remove the book from your cart.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-5">
                <button id="cancelRemove"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button id="confirmRemoveBtn"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                    Remove
                </button>
            </div>
        </div>
    </div>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-3xl mx-auto">

            <!-- Header -->
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('shop') }}"
                    class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Cart</h1>
                    <p class="text-sm text-gray-500">{{ $orders->count() }} {{ Str::plural('item', $orders->count()) }}</p>
                </div>
            </div>

            {{-- Feedback --}}
            @if(session('success'))
            <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                {{ session('error') }}
            </div>
            @endif

            @if($orders->isEmpty())
            {{-- Empty state --}}
            <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-16 flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-2xl bg-[#e9dfcd] flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#a89678]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-2">Your cart is empty</h2>
                <p class="text-gray-400 text-sm mb-6">Browse our collection and add your favourite books.</p>
                <a href="{{ route('shop') }}"
                    class="inline-flex items-center gap-2 bg-[#f09224] hover:bg-[#fcba50] text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                    Browse Shop →
                </a>
            </div>

            @else
            {{-- Items list --}}
            <div class="space-y-3 mb-6">
                @php $total = 0; @endphp
                @foreach($orders as $order)
                @php $total += $order->price * $order->quantity; @endphp
                <div class="cart-item bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-4 flex items-center gap-4"
                    data-id="{{ $order->order_book_id }}"
                    data-price="{{ $order->price }}">

                    {{-- Cover --}}
                    <div class="w-12 h-16 rounded-lg overflow-hidden bg-[#e9dfcd] flex-shrink-0">
                        @if(!empty($order->image) && file_exists(public_path('storage/books/' . $order->image)))
                        <img src="{{ asset('storage/books/' . $order->image) }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#c8b99a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 text-sm truncate">{{ $order->title ?? 'Unknown book' }}</p>
                        @if(!empty($order->author))
                        <p class="text-xs text-gray-400 mt-0.5">{{ $order->author }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">${{ number_format($order->price, 2) }} each</p>
                    </div>

                    {{-- Quantity controls --}}
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <button type="button" class="btn-dec w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition text-gray-600 font-bold text-base leading-none">−</button>
                        <span class="qty-display w-8 text-center text-sm font-bold text-gray-900">{{ $order->quantity }}</span>
                        <button type="button" class="btn-inc w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition text-gray-600 font-bold text-base leading-none">+</button>
                    </div>

                    {{-- Subtotal --}}
                    <div class="text-right flex-shrink-0 w-16">
                        <p class="item-subtotal font-black text-[#f09224] text-sm">${{ number_format($order->price * $order->quantity, 2) }}</p>
                    </div>

                    {{-- Remove button --}}
                    <button type="button"
                        class="open-remove-modal w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition flex-shrink-0"
                        data-id="{{ $order->order_book_id }}"
                        data-action="{{ route('cart.remove', $order->order_book_id) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Subtotal ({{ $orders->sum('quantity') }} {{ Str::plural('unit', $orders->sum('quantity')) }})</span>
                    <span id="summary-subtotal" class="font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex items-center justify-between mb-5 pb-5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Shipping</span>
                    <span class="text-sm text-green-600 font-semibold">Free</span>
                </div>
                <div class="flex items-center justify-between mb-6">
                    <span class="font-bold text-gray-900 text-lg">Total</span>
                    <span id="grand-total" class="text-2xl font-black text-[#f09224]">${{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}"
                    class="w-full block text-center bg-gray-900 hover:bg-[#f09224] text-white font-bold py-3 px-6 rounded-xl transition text-sm">
                    Proceed to Checkout →
                </a>

                <a href="{{ route('shop') }}" class="w-full block text-center text-sm text-gray-400 hover:text-[#f09224] mt-3 transition">
                    Continue shopping
                </a>
            </div>

            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var csrfMeta = document.querySelector('meta[name="csrf-token"]');
                var CSRF = csrfMeta ? csrfMeta.content : '';
                var BASE = "{{ url('') }}";

                function recalcTotal() {
                    var total = 0;
                    var items = document.querySelectorAll('.cart-item');
                    items.forEach(function(item) {
                        var qty = parseInt(item.querySelector('.qty-display').textContent);
                        var price = parseFloat(item.dataset.price);
                        item.querySelector('.item-subtotal').textContent = '$' + (qty * price).toFixed(2);
                        total += qty * price;
                    });
                    var fmt = '$' + total.toFixed(2);
                    var gt = document.getElementById('grand-total');
                    if (gt) gt.textContent = fmt;
                    var ss = document.getElementById('summary-subtotal');
                    if (ss) ss.textContent = fmt;
                    var count = document.querySelectorAll('.cart-item').length;
                    var countStr = count > 99 ? '99+' : String(count);
                    ['cart-badge', 'cart-badge-mobile'].forEach(function(badgeId) {
                        var el = document.getElementById(badgeId);
                        if (el) {
                            el.textContent = countStr;
                            el.style.display = count > 0 ? '' : 'none';
                        }
                    });
                }

                document.querySelectorAll('.cart-item').forEach(function(item) {
                    var id = item.dataset.id;

                    item.querySelector('.btn-inc').addEventListener('click', function() {
                        fetch(BASE + '/cart/increment/' + id, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(function(r) {
                                if (!r.ok) throw new Error('HTTP ' + r.status);
                                return r.json();
                            })
                            .then(function(data) {
                                if (data.ok) {
                                    var el = item.querySelector('.qty-display');
                                    el.textContent = parseInt(el.textContent) + 1;
                                    recalcTotal();
                                }
                            })
                            .catch(function(err) {
                                console.error('increment failed:', err);
                            });
                    });

                    item.querySelector('.btn-dec').addEventListener('click', function() {
                        var el = item.querySelector('.qty-display');
                        var qty = parseInt(el.textContent);
                        if (qty <= 1) {
                            pendingRemoveId = id;
                            pendingRemoveItem = item;
                            removeModal.classList.remove('hidden');
                        } else {
                            fetch(BASE + '/cart/decrement/' + id, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': CSRF,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(function(r) {
                                    if (!r.ok) throw new Error('HTTP ' + r.status);
                                    return r.json();
                                })
                                .then(function(data) {
                                    if (data.ok) {
                                        el.textContent = qty - 1;
                                        recalcTotal();
                                    }
                                })
                                .catch(function(err) {
                                    console.error('decrement failed:', err);
                                });
                        }
                    });
                });

                // Modal de eliminación
                var removeModal = document.getElementById('removeModal');
                var cancelRemove = document.getElementById('cancelRemove');
                var confirmRemoveBtn = document.getElementById('confirmRemoveBtn');
                var pendingRemoveId = null;
                var pendingRemoveItem = null;
                if (removeModal && cancelRemove && confirmRemoveBtn) {
                    document.querySelectorAll('.open-remove-modal').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            pendingRemoveId = btn.dataset.id;
                            pendingRemoveItem = btn.closest('.cart-item');
                            removeModal.classList.remove('hidden');
                        });
                    });
                    confirmRemoveBtn.addEventListener('click', function() {
                        if (!pendingRemoveId || !pendingRemoveItem) return;
                        fetch(BASE + '/cart/remove/' + pendingRemoveId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(function(r) {
                                return r.json();
                            })
                            .then(function(data) {
                                if (data.ok) {
                                    pendingRemoveItem.remove();
                                    recalcTotal();
                                    removeModal.classList.add('hidden');
                                    pendingRemoveId = null;
                                    pendingRemoveItem = null;
                                }
                            })
                            .catch(function(err) {
                                console.error('remove error:', err);
                            });
                    });
                    cancelRemove.addEventListener('click', function() {
                        removeModal.classList.add('hidden');
                        pendingRemoveId = null;
                        pendingRemoveItem = null;
                    });
                    removeModal.addEventListener('click', function(e) {
                        if (e.target === removeModal) {
                            removeModal.classList.add('hidden');
                            pendingRemoveId = null;
                            pendingRemoveItem = null;
                        }
                    });
                }

            } catch (e) {
                console.error('Cart script error:', e);
            }
        });
    </script>

</x-app>