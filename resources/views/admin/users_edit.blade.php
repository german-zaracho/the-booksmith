<x-app>
    <x-slot:title>User - Edit</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-2xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('admin.users') }}"
                   class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition shadow-sm flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224]">User Management</p>
                    <h1 class="text-2xl font-black text-gray-900 leading-tight">Edit User</h1>
                </div>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm">{{ session('error') }}</div>
            @endif

            {{-- ── ÚNICO FORMULARIO ─────────────────────────────────── --}}
            <form action="{{ route('admin.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ── SECTION 1: Profile Info ──────────────────────── --}}
                <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 mb-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Profile Information</p>

                    <div class="space-y-5">
                        {{-- Avatar --}}
                        <div class="flex items-center gap-5">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-[#e9dfcd] flex-shrink-0">
                                <img id="profile-preview"
                                     src="{{ $user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)) ? asset('storage/profilePhoto/' . $user->img) : asset('assets/imgs/user.png') }}"
                                     class="w-full h-full object-cover" alt="Avatar">
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">Profile Photo</p>
                                <label class="cursor-pointer inline-flex items-center gap-1.5 text-sm font-semibold text-[#f09224] hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Upload new photo
                                    <input type="file" name="img" id="img" accept="image/*" class="hidden"
                                           onchange="document.getElementById('profile-preview').src = URL.createObjectURL(this.files[0])">
                                </label>
                                @error('img')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                                   class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('name') border-red-400 @enderror">
                            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                   class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- ── SECTION 2: Shipping Info ──────────────────────── --}}
                <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 mb-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Shipping Information</p>
                    <p class="text-xs text-gray-400 mb-5">Address used for deliveries and checkout.</p>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                                <input id="phone" name="phone" type="text"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="+54 11 1234-5678"
                                       class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                            </div>
                            <div>
                                <label for="zip_code" class="block text-sm font-semibold text-gray-700 mb-1">ZIP Code</label>
                                <input id="zip_code" name="zip_code" type="text"
                                       value="{{ old('zip_code', $user->zip_code) }}"
                                       placeholder="1234"
                                       class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                            <input id="address" name="address" type="text"
                                   value="{{ old('address', $user->address) }}"
                                   placeholder="Av. Corrientes 1234"
                                   class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 mb-1">City</label>
                                <input id="city" name="city" type="text"
                                       value="{{ old('city', $user->city) }}"
                                       placeholder="Buenos Aires"
                                       class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                            </div>
                            <div>
                                <label for="province" class="block text-sm font-semibold text-gray-700 mb-1">Province / State</label>
                                <input id="province" name="province" type="text"
                                       value="{{ old('province', $user->province) }}"
                                       placeholder="Buenos Aires"
                                       class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── SECTION 3: Subscription ───────────────────────── --}}
                <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 mb-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Subscription</p>

                    <label for="subscription" class="block text-xs font-semibold uppercase tracking-widest text-gray-400 mb-2">Select a Plan</label>
                    <select name="subscription" id="subscription"
                            class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#f09224] mb-2">
                        <option value="" {{ is_null($user->subscription) ? 'selected' : '' }}>No subscription / Cancel Subscription</option>
                        @foreach($book_plans as $book_plan)
                        <option value="{{ $book_plan->book_plan_id }}"
                                data-description="{{ $book_plan->description }}"
                                {{ $user->subscription && $user->subscription->bookPlan->book_plan_id == $book_plan->book_plan_id ? 'selected' : '' }}>
                            {{ $book_plan->name }} — ${{ $book_plan->total_price }}/month
                        </option>
                        @endforeach
                    </select>
                    <p id="plan-description" class="text-xs text-gray-400 italic min-h-[1.25rem]"></p>
                </div>

                {{-- ── Save button ───────────────────────────────────── --}}
                <button type="submit"
                        class="w-full bg-gray-900 hover:bg-[#f09224] text-white font-bold py-3 rounded-xl transition text-sm mb-6">
                    Save Changes
                </button>

            </form>

            {{-- ── SECTION 4: Danger Zone (fuera del form principal) ── --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-red-400 mb-5">Danger Zone</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Reset Password</p>
                        <p class="text-xs text-gray-400">Sets the password back to the default: <span class="font-mono">asdasd12</span></p>
                    </div>
                    <button type="button" onclick="openResetPasswordModal()"
                            class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold px-4 py-2 rounded-xl transition border border-red-200">
                        Reset Password
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- ── Reset Password Modal ─────────────────────────────────────── --}}
    <div id="resetPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Reset password?</h3>
                    <p class="text-sm text-gray-500">This will set a default password for the user.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-2">
                <button onclick="closeResetPasswordModal()"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form action="{{ route('admin.resetPassword', $user->user_id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                        Confirm Reset
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-app>

<script>
    const select = document.getElementById('subscription');
    const descDiv = document.getElementById('plan-description');

    function updateDescription() {
        const opt = select.options[select.selectedIndex];
        descDiv.textContent = opt.getAttribute('data-description') || '';
    }

    select.addEventListener('change', updateDescription);
    updateDescription();

    function openResetPasswordModal() {
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    }

    function closeResetPasswordModal() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
    }
</script>