@php
$usersJson = $users->mapWithKeys(function($user) {
return [
$user->user_id => [
'name' => $user->name,
'email' => $user->email,
'phone' => $user->phone ?? null,
'address' => $user->address ?? null,
'city' => $user->city ?? null,
'province' => $user->province ?? null,
'zip_code' => $user->zip_code ?? null,
'img' => ($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))
? asset('storage/profilePhoto/' . $user->img)
: asset('assets/imgs/user.png'),
'subscription' => ($user->subscription && $user->subscription->bookPlan) ? [
'plan' => $user->subscription->bookPlan->name,
'price' => $user->subscription->bookPlan->total_price,
'start' => $user->subscription->start_date,
'end' => $user->subscription->end_date,
'active' => (bool) $user->subscription->is_active,
'method' => $user->subscription->payment_method ?? 'N/A',
'status' => $user->subscription->payment_status ?? 'N/A',
] : null,
'purchases' => $user->purchaseHistory->map(fn($p) => [
'id' => $p->buy_id,
'total' => number_format($p->total_price, 2),
'date' => $p->date,
'method' => $p->payment_method ?? 'N/A',
'status' => $p->status_name ?? 'N/A',
'items' => collect($p->items)->map(fn($item) => [
'title' => $item->title ?? 'Unknown',
'image' => $item->image ? asset('storage/books/' . $item->image) : null,
'quantity' => $item->quantity,
'price' => number_format($item->price, 2),
'subtotal' => number_format($item->price * $item->quantity, 2),
])->values(),
])->values(),
]
];
});

$noImageUrl = asset('assets/imgs/user.png');
$noBookImage = asset('assets/imgs/user.png');

@endphp

<x-app>
    <x-slot:title>User Management</x-slot:title>

    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                        <p class="text-sm text-gray-500">{{ $users->count() }} registered users</p>
                    </div>
                </div>
                <button id="openCreateUserModal"
                    class="bg-[#f09224] hover:bg-[#fcba50] text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-sm transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New User
                </button>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">{{ session('error') }}</div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">User</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Subscription</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    @if($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))
                                    <img src="{{ asset('storage/profilePhoto/' . $user->img) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0">
                                    @else
                                    <img src="{{ asset('assets/imgs/user.png') }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0">
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400">#{{ $user->user_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @if($user->role_id === 1)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Admin</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">User</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->subscription && $user->subscription->bookPlan)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    {{ $user->subscription->bookPlan->name }}
                                </span>
                                @else
                                <span class="text-xs text-gray-400">No subscription</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition open-details-btn"
                                        data-user-id="{{ $user->user_id }}">
                                        Details
                                    </button>
                                    @if($user->role_id === 2)
                                    <a href="{{ route('admin.edit', $user->user_id) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-700 hover:bg-red-100 transition open-modal"
                                        data-id="{{ $user->user_id }}">
                                        Delete
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- ── User Details Modal ───────────────────────────────────────── --}}
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <img id="detailImg" src="" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h2 id="detailName" class="text-lg font-bold text-gray-900"></h2>
                        <p id="detailEmail" class="text-sm text-gray-500"></p>
                    </div>
                </div>
                <button onclick="closeDetails()" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-3">

                {{-- Profile Info — starts OPEN --}}
                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <button type="button" onclick="toggleSection('sectionProfile', this)"
                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition text-left">
                        <span class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile Information
                        </span>
                        <svg class="chevron w-4 h-4 text-gray-400 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="sectionProfile" class="px-4 py-4">
                        <div id="detailProfile" class="text-sm text-gray-600"></div>
                    </div>
                </div>

                {{-- Subscription — starts CLOSED --}}
                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <button type="button" onclick="toggleSection('sectionSubscription', this)"
                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition text-left">
                        <span class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Subscription
                        </span>
                        <svg class="chevron w-4 h-4 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="sectionSubscription" class="hidden px-4 py-4">
                        <div id="detailSubscription" class="text-sm text-gray-600"></div>
                    </div>
                </div>

                {{-- Purchase History — starts CLOSED --}}
                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <button type="button" onclick="toggleSection('sectionPurchases', this)"
                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition text-left">
                        <span class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Purchase History
                        </span>
                        <svg class="chevron w-4 h-4 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="sectionPurchases" class="hidden px-4 py-4">
                        <div id="detailPurchases" class="space-y-2"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Delete Modal ─────────────────────────────────────────────── --}}
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-96">
            <h2 class="text-lg font-bold mb-2 text-gray-900">Confirm Delete</h2>
            <p class="mb-6 text-sm text-gray-500">Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDelete" class="px-4 py-2 rounded-xl text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
                <button id="confirmDelete" class="px-4 py-2 rounded-xl text-sm font-medium bg-red-600 hover:bg-red-700 text-white transition">Delete</button>
            </div>
        </div>
    </div>

    {{-- ── Create User Modal ────────────────────────────────────────── --}}
    <div id="createUserModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-96">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-gray-900">Create New User</h2>
                <button id="closeCreateUserModal" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="text" id="password" name="password" required
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f09224]">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" id="closeCreateUserModal2"
                        class="px-4 py-2 rounded-xl text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-xl text-sm font-medium bg-[#f09224] hover:bg-[#fcba50] text-white transition">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script id="users-json" type="application/json">
        {!!json_encode($usersJson) !!}
    </script>

    <script>
        // Data prepared cleanly in @php block above — zero PHP inside JS
        const usersData = JSON.parse(document.getElementById('users-json').textContent);

        function toggleSection(id, btn) {
            const section = document.getElementById(id);
            const chevron = btn.querySelector('.chevron');
            section.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        function openDetails(userId) {
            const u = usersData[userId];
            if (!u) return;

            document.getElementById('detailName').textContent = u.name;
            document.getElementById('detailEmail').textContent = u.email;
            document.getElementById('detailImg').src = u.img;

            // Reset: profile open, subscription & purchases closed
            document.getElementById('sectionProfile').classList.remove('hidden');
            document.getElementById('sectionSubscription').classList.add('hidden');
            document.getElementById('sectionPurchases').classList.add('hidden');
            document.querySelectorAll('#detailsModal .chevron').forEach((ch, i) => {
                ch.classList.toggle('rotate-180', i === 0);
            });

            // Profile Info
            const profileEl = document.getElementById('detailProfile');
            const fields = [{
                    label: 'Phone',
                    value: u.phone
                },
                {
                    label: 'Address',
                    value: u.address
                },
                {
                    label: 'City',
                    value: u.city
                },
                {
                    label: 'Province',
                    value: u.province
                },
                {
                    label: 'ZIP Code',
                    value: u.zip_code
                },
            ].filter(f => f.value);

            profileEl.innerHTML = fields.length > 0 ?
                '<div class="grid grid-cols-2 gap-3 text-xs">' +
                fields.map(f =>
                    '<div><span class="text-gray-400">' + f.label + '</span><br>' +
                    '<span class="font-medium text-gray-700">' + f.value + '</span></div>'
                ).join('') + '</div>' :
                '<p class="text-gray-400 text-sm">No additional profile information available.</p>';

            // Subscription
            const subEl = document.getElementById('detailSubscription');
            if (u.subscription) {
                const s = u.subscription;
                const badge = s.active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500';
                subEl.innerHTML =
                    '<div class="flex items-center justify-between mb-3">' +
                    '<span class="font-semibold text-gray-800 text-base">' + s.plan + '</span>' +
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' + badge + '">' +
                    (s.active ? 'Active' : 'Inactive') +
                    '</span>' +
                    '</div>' +
                    '<div class="grid grid-cols-2 gap-2 text-xs">' +
                    '<div><span class="text-gray-400">Price</span><br><span class="font-medium text-gray-700">$' + s.price + '/mo</span></div>' +
                    '<div><span class="text-gray-400">Payment method</span><br><span class="font-medium text-gray-700 capitalize">' + s.method + '</span></div>' +
                    '<div><span class="text-gray-400">Start date</span><br><span class="font-medium text-gray-700">' + s.start + '</span></div>' +
                    '<div><span class="text-gray-400">End date</span><br><span class="font-medium text-gray-700">' + s.end + '</span></div>' +
                    '<div><span class="text-gray-400">Payment status</span><br><span class="font-medium text-gray-700 capitalize">' + s.status + '</span></div>' +
                    '</div>';
            } else {
                subEl.innerHTML = '<p class="text-gray-400 text-sm">This user has no active subscription.</p>';
            }

            // Purchase History
            const purchEl = document.getElementById('detailPurchases');
            if (!u.purchases || u.purchases.length === 0) {
                purchEl.innerHTML = '<p class="text-gray-400 text-sm">This user has no purchase history.</p>';
            } else {
                const statusColors = {
                    'Completed': 'bg-green-100 text-green-700',
                    'Pending': 'bg-yellow-100 text-yellow-700',
                    'Canceled': 'bg-red-100 text-red-700',
                    'Shipped': 'bg-purple-100 text-purple-700',
                };

                purchEl.innerHTML = u.purchases.map(function(p, idx) {
                    const color = statusColors[p.status] || 'bg-gray-100 text-gray-600';
                    const methodIcon = p.method === 'mercadopago' ? '🔵' : p.method === 'credit_card' ? '💳' : '—';
                    const orderId = 'order-' + userId + '-' + idx;

                    let itemsHtml = '';
                    if (p.items && p.items.length > 0) {
                        itemsHtml = p.items.map(function(item) {
                            const imgSrc = item.image || u.img;
                            return '<div class="flex items-center gap-3 py-2 border-t border-gray-100">' +
                                '<img src="' + imgSrc + '" class="w-10 h-14 object-cover rounded shadow flex-shrink-0" onerror="this.style.display=\'none\'">' +
                                '<div class="flex-1 min-w-0">' +
                                '<p class="text-xs font-medium text-gray-800 truncate">' + item.title + '</p>' +
                                '<p class="text-xs text-gray-400">Qty: ' + item.quantity + ' · $' + item.price + ' each</p>' +
                                '</div>' +
                                '<p class="text-xs font-semibold text-gray-700 flex-shrink-0">$' + item.subtotal + '</p>' +
                                '</div>';
                        }).join('');
                    } else {
                        itemsHtml = '<p class="text-xs text-gray-400 pt-2 border-t border-gray-100">No item details available.</p>';
                    }

                    return '<div class="border border-gray-100 rounded-xl overflow-hidden">' +
                        '<button type="button" onclick="toggleSection(\'' + orderId + '\', this)" ' +
                        'class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition text-left">' +
                        '<div>' +
                        '<p class="text-xs font-semibold text-gray-700">Order #' + p.id + ' · ' + p.date + '</p>' +
                        '<p class="text-xs text-gray-400">' + methodIcon + ' ' + p.method + '</p>' +
                        '</div>' +
                        '<div class="flex items-center gap-2">' +
                        '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ' + color + '">' + p.status + '</span>' +
                        '<svg class="chevron w-4 h-4 text-gray-400 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />' +
                        '</svg>' +
                        '</div>' +
                        '</button>' +
                        '<div id="' + orderId + '" class="hidden px-4 pb-3">' +
                        itemsHtml +
                        '<div class="flex justify-between items-center pt-3 mt-2 border-t border-gray-200">' +
                        '<span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</span>' +
                        '<span class="text-sm font-bold text-orange-500">$' + p.total + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }).join('');
            }

            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function closeDetails() {
            document.getElementById('detailsModal').classList.add('hidden');
        }

        document.getElementById('detailsModal').addEventListener('click', function(e) {
            if (e.target === this) closeDetails();
        });

        document.querySelectorAll('.open-details-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                openDetails(btn.dataset.userId);
            });
        });

        // Delete modal
        let userIdToDelete = null;
        document.querySelectorAll('.open-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                userIdToDelete = btn.dataset.id;
                document.getElementById('deleteModal').classList.remove('hidden');
            });
        });
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (!userIdToDelete) return;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/users/' + userIdToDelete;
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                '<input type="hidden" name="_method" value="DELETE">';
            document.body.appendChild(form);
            form.submit();
        });

        // Create user modal
        const createModal = document.getElementById('createUserModal');
        document.getElementById('openCreateUserModal').addEventListener('click', function() {
            fetch("{{ route('admin.getNewUserDefaults') }}")
                .then(function(r) {
                    return r.json();
                })
                .then(function(data) {
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('password').value = data.password;
                    createModal.classList.remove('hidden');
                });
        });
        ['closeCreateUserModal', 'closeCreateUserModal2'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) el.addEventListener('click', function() {
                createModal.classList.add('hidden');
            });
        });
    </script>



</x-app>