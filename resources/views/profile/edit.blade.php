<x-app>
    <x-slot:title>Edit Profile</x-slot:title>

    <div class="min-h-screen bg-[#faf7f2] py-12 px-4">
        <div class="max-w-2xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('profile') }}"
                   class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition shadow-sm flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224]">Account</p>
                    <h1 class="text-2xl font-black text-gray-900 leading-tight">Edit Profile</h1>
                </div>
            </div>

            {{-- ── SECTION 1: Profile Info ──────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 mb-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Profile Information</p>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PATCH')

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
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
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

                    <button type="submit"
                            class="w-full bg-gray-900 hover:bg-[#f09224] text-white font-bold py-3 rounded-xl transition text-sm">
                        Save Profile
                    </button>
                </form>
            </div>

            {{-- ── SECTION 2: Shipping Info ─────────────────────────── --}}
            <div id="shipping" class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 mb-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Shipping Information</p>
                <p class="text-xs text-gray-400 mb-5">Used to pre-fill your address at checkout.</p>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

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

                    <button type="submit"
                            class="w-full bg-gray-900 hover:bg-[#f09224] text-white font-bold py-3 rounded-xl transition text-sm">
                        Save Shipping Info
                    </button>
                </form>
            </div>

            {{-- ── SECTION 3: Change Password ──────────────────────── --}}
            <div class="bg-white rounded-2xl border border-[#ede8dd] shadow-sm p-6 mb-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Change Password</p>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1">Current Password</label>
                        <input id="current_password" name="current_password" type="password"
                               class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('current_password', 'updatePassword') border-red-400 @enderror">
                        @error('current_password', 'updatePassword')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                        <input id="password" name="password" type="password"
                               class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224] @error('password', 'updatePassword') border-red-400 @enderror">
                        @error('password', 'updatePassword')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                    </div>

                    @if(session('status') === 'password-updated')
                    <p class="text-sm text-green-600 font-medium">Password updated successfully.</p>
                    @endif

                    <button type="submit"
                            class="w-full bg-gray-900 hover:bg-[#f09224] text-white font-bold py-3 rounded-xl transition text-sm">
                        Update Password
                    </button>
                </form>
            </div>

            {{-- ── SECTION 4: Danger Zone ───────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-red-400 mb-1">Danger Zone</p>
                <p class="text-sm text-gray-500 mb-4">Once your account is deleted, all data will be permanently removed.</p>
                <button id="openDeleteModal"
                        class="text-sm font-semibold text-red-600 hover:underline">
                    Delete my account
                </button>
            </div>

        </div>
    </div>

    {{-- Delete account modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Delete account?</h3>
                    <p class="text-sm text-gray-500">This action cannot be undone.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm your password</label>
                    <input type="password" name="password" placeholder="Your password"
                           class="w-full rounded-xl border border-gray-200 bg-[#faf7f2] py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('password', 'userDeletion')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" id="closeDeleteModal"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Cancel</button>
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dm     = document.getElementById('deleteModal');
            var openD  = document.getElementById('openDeleteModal');
            var closeD = document.getElementById('closeDeleteModal');
            if (openD)  openD.addEventListener('click',  function () { dm.classList.remove('hidden'); });
            if (closeD) closeD.addEventListener('click', function () { dm.classList.add('hidden'); });
            if (dm)     dm.addEventListener('click', function (e) { if (e.target === dm) dm.classList.add('hidden'); });

            // Scroll to anchor on load (#shipping)
            if (window.location.hash) {
                var target = document.querySelector(window.location.hash);
                if (target) setTimeout(function () { target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
            }
        });
    </script>

</x-app>