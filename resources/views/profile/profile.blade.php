<x-app>
    <x-slot:title>My Profile</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-5xl mx-auto">

            {{-- Page header --}}
            <div class="mb-8">
                <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-1">Account</p>
                <h1 class="text-3xl font-black text-gray-900">My Profile</h1>
            </div>

            {{-- Flash messages --}}
            @if(session('status') === 'profile-updated' || session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('status') === 'profile-updated' ? 'Profile updated successfully.' : session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ── LEFT COLUMN ─────────────────────────────────── --}}
                <div class="space-y-6">

                    {{-- Avatar + basic info --}}
                    <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#e9dfcd] shadow-md mb-4 flex-shrink-0">
                            @if($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))
                                <img src="{{ asset('storage/profilePhoto/' . $user->img) }}" class="w-full h-full object-cover" alt="Avatar">
                            @else
                                <img src="{{ asset('assets/imgs/user.png') }}" class="w-full h-full object-cover" alt="Avatar">
                            @endif
                        </div>
                        <h2 class="text-lg font-black text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-400 mt-0.5 mb-5">{{ $user->email }}</p>
                        <a href="{{ route('profile.edit') }}"
                           class="w-full text-center bg-gray-900 hover:bg-[#f09224] text-white font-semibold text-sm py-2.5 rounded-xl transition">
                            Edit Profile
                        </a>
                    </div>

                    {{-- Subscription --}}
                    <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-4">Subscription</p>

                        @if($user->subscription && $user->subscription->bookPlan)
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 rounded-xl bg-[#f09224] flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">{{ $user->subscription->bookPlan->name }}</p>
                                    <p class="text-xs text-gray-400">${{ $user->subscription->bookPlan->total_price }}/month</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">{{ $user->subscription->bookPlan->description }}</p>
                            <p class="text-xs text-gray-400 mb-4">
                                Valid until {{ \Carbon\Carbon::parse($user->subscription->end_date)->format('M j, Y') }}
                            </p>
                            <div class="flex gap-2">
                                <button id="openSubscriptionModal"
                                        class="flex-1 text-sm font-semibold py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                    Change
                                </button>
                                <button id="openCancelModal"
                                        class="flex-1 text-sm font-semibold py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 transition">
                                    Cancel
                                </button>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 mb-4">No active subscription.</p>
                            <div class="flex gap-2">
                                <a href="{{ route('subscriptions') }}"
                                   class="flex-1 text-center bg-[#f09224] hover:bg-[#fcba50] text-white font-semibold text-sm py-2.5 rounded-xl transition">
                                    Browse Plans
                                </a>
                                <button id="openSubscriptionModal"
                                        class="flex-1 text-sm font-semibold py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                    Select Plan
                                </button>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- ── RIGHT COLUMN ─────────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Shipping info --}}
                    <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Shipping Information</p>
                            <a href="{{ route('profile.edit') }}#shipping" class="text-xs text-[#f09224] hover:underline">Edit</a>
                        </div>

                        @php $na = '<span class="text-gray-300 italic">—</span>'; @endphp

                        @if(!$user->phone && !$user->address)
                            <div class="flex items-center gap-3 p-4 bg-[#faf7f2] rounded-xl border border-dashed border-[#e9dfcd]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#a89678] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">No shipping info yet</p>
                                    <p class="text-xs text-gray-400">Add your address to speed up checkout.</p>
                                </div>
                                <a href="{{ route('profile.edit') }}#shipping"
                                   class="ml-auto text-sm font-semibold text-[#f09224] hover:underline whitespace-nowrap">Add now</a>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Phone</p>
                                    <p class="text-sm text-gray-800">{!! $user->phone ? e($user->phone) : $na !!}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">ZIP Code</p>
                                    <p class="text-sm text-gray-800">{!! $user->zip_code ? e($user->zip_code) : $na !!}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Address</p>
                                    <p class="text-sm text-gray-800">{!! $user->address ? e($user->address) : $na !!}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">City</p>
                                    <p class="text-sm text-gray-800">{!! $user->city ? e($user->city) : $na !!}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Province / State</p>
                                    <p class="text-sm text-gray-800">{!! $user->province ? e($user->province) : $na !!}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Purchases --}}
                    <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-4">Purchases</p>
                        <div class="flex items-center gap-4 p-4 bg-[#faf7f2] rounded-xl border border-[#ede8dd]">
                            <div class="w-10 h-10 rounded-xl bg-[#e9dfcd] flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#a89678]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Order History</p>
                                <p class="text-xs text-gray-400">View all your past purchases</p>
                            </div>
                            <a href="{{ route('orders.history') }}"
                               class="ml-auto text-sm font-semibold text-[#f09224] hover:underline whitespace-nowrap">View all</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ── Modal: Edit Subscription ─────────────────────────────────── --}}
    <div id="subscriptionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <h3 class="font-bold text-gray-900 text-base mb-4">Edit Subscription</h3>
            <form action="{{ route('profile.subscription.update') }}" method="POST">
                @csrf
                @method('PUT')
                <label class="block text-xs font-semibold uppercase tracking-widest text-gray-400 mb-2">Select a Plan</label>
                <select name="subscription" id="subscription"
                        class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#f09224] mb-2">
                    <option value="" {{ is_null($user->subscription) ? 'selected' : '' }}>No subscription</option>
                    @foreach($book_plans as $book_plan)
                    <option value="{{ $book_plan->book_plan_id }}"
                            data-description="{{ $book_plan->description }}"
                            {{ $user->subscription && $user->subscription->bookPlan->book_plan_id == $book_plan->book_plan_id ? 'selected' : '' }}>
                        {{ $book_plan->name }} — ${{ $book_plan->total_price }}/month
                    </option>
                    @endforeach
                </select>
                <p id="planDescription" class="text-xs text-gray-400 italic min-h-[2rem] mb-4"></p>
                <div class="flex gap-3">
                    <button type="button" id="closeSubscriptionModal"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Cancel</button>
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-[#f09224] text-white hover:bg-[#fcba50] transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Modal: Cancel Subscription ──────────────────────────────── --}}
    <div id="cancelSubscriptionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Cancel subscription?</h3>
                    <p class="text-sm text-gray-500">You will lose access to your current plan.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-2">
                <button type="button" id="closeCancelModal"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Keep it</button>
                <form action="{{ route('profile.subscription.cancel') }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition">Yes, cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function bindModal(openId, closeId, modalId) {
                var m   = document.getElementById(modalId);
                var btn = document.getElementById(openId);
                var cls = document.getElementById(closeId);
                if (!m || !btn) return;
                btn.addEventListener('click', function () { m.classList.remove('hidden'); });
                if (cls) cls.addEventListener('click', function () { m.classList.add('hidden'); });
                m.addEventListener('click', function (e) { if (e.target === m) m.classList.add('hidden'); });
            }
            bindModal('openSubscriptionModal', 'closeSubscriptionModal', 'subscriptionModal');
            bindModal('openCancelModal', 'closeCancelModal', 'cancelSubscriptionModal');

            var selectEl = document.getElementById('subscription');
            var descEl   = document.getElementById('planDescription');
            function updateDesc() {
                var opt = selectEl && selectEl.options[selectEl.selectedIndex];
                if (descEl) descEl.textContent = opt ? (opt.dataset.description || '') : '';
            }
            if (selectEl) { selectEl.addEventListener('change', updateDesc); updateDesc(); }
        });
    </script>

</x-app>