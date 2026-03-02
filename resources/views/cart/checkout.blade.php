<x-app>
    <x-slot:title>Checkout</x-slot:title>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-8 text-center">Checkout</h1>

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg text-sm">
            {{ session('error') }}
        </div>
        @endif

        @php $u = Auth::user(); @endphp

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ── LEFT: Shipping + Payment ──────────────────────── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Shipping --}}
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-[#f09224] text-white text-xs flex items-center justify-center font-bold">1</span>
                                Shipping Information
                            </h2>
                            @if($u->address)
                            <span class="text-xs text-green-600 font-medium">
                                &#10003; Pre-filled from profile
                                <a href="{{ route('profile.edit') }}" class="text-gray-400 hover:text-gray-600 underline ml-1">edit</a>
                            </span>
                            @else
                            <a href="{{ route('profile.edit') }}" class="text-xs text-[#f09224] hover:underline font-medium">&#9998; Save to profile</a>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name', $u->name) }}" placeholder="John Doe"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('full_name') border-red-500 @enderror">
                                @error('full_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" value="{{ old('phone', $u->phone) }}" placeholder="+54 11 1234-5678"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('phone') border-red-500 @enderror">
                                @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ZIP Code <span class="text-red-500">*</span></label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $u->zip_code) }}" placeholder="1234"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('zip_code') border-red-500 @enderror">
                                @error('zip_code') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                                <input type="text" name="address" value="{{ old('address', $u->address) }}" placeholder="123 Main St"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('address') border-red-500 @enderror">
                                @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city', $u->city) }}" placeholder="Buenos Aires"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('city') border-red-500 @enderror">
                                @error('city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Province / State <span class="text-red-500">*</span></label>
                                <input type="text" name="province" value="{{ old('province', $u->province) }}" placeholder="Buenos Aires"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('province') border-red-500 @enderror">
                                @error('province') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <input type="checkbox" name="save_to_profile" id="save_to_profile" value="1"
                                class="accent-[#f09224] w-4 h-4" {{ $u->address ? 'checked' : '' }}>
                            <label for="save_to_profile" class="text-sm text-gray-600 cursor-pointer">
                                Save this information to my profile for future orders
                            </label>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#f09224] text-white text-xs flex items-center justify-center font-bold">2</span>
                            Payment Method
                        </h2>

                        @error('payment_method')
                        <p class="mb-3 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <div class="space-y-3">

                            {{-- MercadoPago option --}}
                            <label id="label-mercadopago"
                                class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition border-[#009ee3] bg-blue-50">
                                <input type="radio" name="payment_method" value="mercadopago"
                                    class="w-4 h-4 accent-[#009ee3]" checked
                                    onchange="switchPayment('mercadopago')">
                                <div class="flex items-center gap-3 flex-1">
                                    <svg width="34" height="34" viewBox="0 0 48 48" fill="none">
                                        <circle cx="24" cy="24" r="24" fill="#009ee3" />
                                        <path d="M24 12C17.373 12 12 17.373 12 24C12 30.627 17.373 36 24 36C30.627 36 36 30.627 36 24C36 17.373 30.627 12 24 12Z" fill="white" />
                                        <path d="M30 21C30 24.314 27.314 27 24 27C20.686 27 18 24.314 18 21C18 17.686 20.686 15 24 15C27.314 15 30 17.686 30 21Z" fill="#009ee3" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">MercadoPago</p>
                                        <p class="text-xs text-gray-500">Pay with your MercadoPago account</p>
                                    </div>
                                </div>
                            </label>

                            {{-- Wallet Brick container — shown when MP is selected --}}
                            <div id="mpWalletContainer" class="px-2 py-3">
                                @if($mpPreferenceId)
                                <div id="wallet_container"></div>
                                @else
                                <p class="text-xs text-red-500 text-center">
                                    Could not load MercadoPago. Please refresh the page.
                                </p>
                                @endif
                            </div>

                            {{-- Credit Card (demo) --}}
                            <label id="label-credit_card"
                                class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition border-gray-200 bg-white hover:border-gray-300">
                                <input type="radio" name="payment_method" value="credit_card"
                                    class="w-4 h-4 accent-gray-600"
                                    onchange="switchPayment('credit_card')">
                                <div class="flex items-center gap-3 flex-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Credit Card</p>
                                        <p class="text-xs text-gray-500">Visa, Mastercard, Amex</p>
                                    </div>
                                </div>
                                <span class="text-xs text-orange-500 font-medium bg-orange-50 px-2 py-0.5 rounded-full border border-orange-200">Demo</span>
                            </label>

                            {{-- Credit card form --}}
                            <div id="ccForm" class="hidden border border-gray-200 rounded-xl p-5 space-y-4">
                                <p class="text-xs text-orange-600 bg-orange-50 border border-orange-200 rounded-lg px-3 py-2">
                                    &#9888; <strong>Demo mode</strong> — no real card is processed.
                                </p>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                                    <input type="text" name="card_name" value="{{ old('card_name', $u->name) }}"
                                        placeholder="Name as it appears on card"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('card_name') border-red-500 @enderror">
                                    @error('card_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                    <input type="text" name="card_number" value="{{ old('card_number') }}"
                                        placeholder="4242 4242 4242 4242" maxlength="19"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 font-mono @error('card_number') border-red-500 @enderror"
                                        oninput="formatCardNumber(this)">
                                    @error('card_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                        <input type="text" name="card_expiry" value="{{ old('card_expiry') }}"
                                            placeholder="MM/YY" maxlength="5"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 font-mono @error('card_expiry') border-red-500 @enderror"
                                            oninput="formatExpiry(this)">
                                        @error('card_expiry') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" name="card_cvv" value="{{ old('card_cvv') }}"
                                            placeholder="123" maxlength="4"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 font-mono @error('card_cvv') border-red-500 @enderror">
                                        @error('card_cvv') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                {{-- Submit button only for credit card --}}
                                <button type="submit"
                                    class="w-full bg-gray-700 hover:bg-gray-900 text-white py-3 rounded-xl font-bold text-sm transition shadow-md flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Confirm &amp; Pay
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── RIGHT: Order Summary ──────────────────────────── --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h2>

                        <div class="space-y-3 mb-4">
                            @foreach($orders as $order)
                            <div class="flex items-center gap-3">
                                @if(!empty($order->image) && file_exists(public_path('storage/books/' . $order->image)))
                                <img src="{{ asset('storage/books/' . $order->image) }}" class="w-9 h-12 object-cover rounded shadow flex-shrink-0">
                                @else
                                <img src="{{ asset('assets/imgs/no-image.jpg') }}" class="w-9 h-12 object-cover rounded shadow flex-shrink-0">
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $order->title ?? 'Book' }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $order->quantity }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 flex-shrink-0">
                                    ${{ number_format($order->price * $order->quantity, 2) }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600 font-medium">Free</span>
                            </div>
                            <div class="flex justify-between text-base font-bold text-gray-800 pt-2 border-t border-gray-100">
                                <span>Total</span>
                                <span class="text-[#f09224]">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('cart') }}" class="mt-4 w-full text-center block text-sm text-gray-500 hover:text-gray-700 transition">
                            &#8592; Back to Cart
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- MercadoPago SDK v2 --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mpPreferenceId = "{{ $mpPreferenceId ?? '' }}";
        const mpPublicKey = "{{ $mpPublicKey ?? '' }}";

        if (mpPreferenceId) {
            const mp = new MercadoPago(mpPublicKey, {
                locale: 'es-AR'
            });

            mp.bricks().create("wallet", "wallet_container", {
                initialization: {
                    preferenceId: mpPreferenceId,
                    redirectMode: "self",
                },
                customization: {
                    texts: {
                        action: "pay",
                        valueProp: "security_safety",
                    },
                },
            });
        }

        function switchPayment(value) {
            const mpLabel = document.getElementById('label-mercadopago');
            const ccLabel = document.getElementById('label-credit_card');
            const mpWallet = document.getElementById('mpWalletContainer');
            const ccForm = document.getElementById('ccForm');

            if (value === 'mercadopago') {
                mpLabel.classList.add('border-[#009ee3]', 'bg-blue-50');
                mpLabel.classList.remove('border-gray-200', 'bg-white');
                ccLabel.classList.remove('border-gray-600', 'bg-gray-50');
                ccLabel.classList.add('border-gray-200', 'bg-white');
                mpWallet.classList.remove('hidden');
                ccForm.classList.add('hidden');
            } else {
                ccLabel.classList.add('border-gray-600', 'bg-gray-50');
                ccLabel.classList.remove('border-gray-200', 'bg-white');
                mpLabel.classList.remove('border-[#009ee3]', 'bg-blue-50');
                mpLabel.classList.add('border-gray-200', 'bg-white');
                ccForm.classList.remove('hidden');
                mpWallet.classList.add('hidden');
            }
        }

        function formatCardNumber(input) {
            let v = input.value.replace(/\D/g, '').substring(0, 16);
            input.value = v.replace(/(.{4})/g, '$1 ').trim();
        }

        function formatExpiry(input) {
            let v = input.value.replace(/\D/g, '').substring(0, 4);
            if (v.length >= 3) v = v.substring(0, 2) + '/' + v.substring(2);
            input.value = v;
        }
    </script>

</x-app>