@php
$chartData = json_encode($revenueByMonth->pluck('revenue'));
$chartLabels = json_encode($revenueByMonth->pluck('month'));
$maxRevenue = $revenueByMonth->max('revenue') ?: 1;
@endphp

<x-app>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- ── Header ──────────────────────────────────────────── --}}
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#f09224] flex items-center justify-center shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 leading-tight">Admin Dashboard</h1>
                    <p class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name }} · {{ now()->format('F Y') }}</p>
                </div>
            </div>

            {{-- ── KPI Cards ────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                {{-- Monthly Revenue --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Monthly Revenue</span>
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($monthlyRevenue, 2) }}</p>
                    @if($revenueChange !== null)
                    <p class="text-xs mt-1 {{ $revenueChange >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $revenueChange >= 0 ? '↑' : '↓' }} {{ abs($revenueChange) }}% vs last month
                    </p>
                    @else
                    <p class="text-xs mt-1 text-gray-400">First month of data</p>
                    @endif
                </div>

                {{-- Monthly Orders --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Orders This Month</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $monthlyOrders }}</p>
                    <p class="text-xs mt-1 text-gray-400">Completed purchases</p>
                </div>

                {{-- Active Subscriptions --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Active Subscriptions</span>
                        <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeSubscriptions }}</p>
                    <p class="text-xs mt-1 text-gray-400">Users with active plans</p>
                </div>

                {{-- Total Users --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Registered Users</span>
                        <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#f09224]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-xs mt-1 text-gray-400">Non-admin accounts</p>
                </div>

            </div>

            {{-- ── Revenue Chart + Top Plan ─────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- Revenue last 6 months --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-700 mb-5 uppercase tracking-wide">Revenue — Last 6 Months</h2>
                    <div class="flex items-end gap-2 h-36">
                        @foreach($revenueByMonth as $item)
                        @php
                        $pct = $maxRevenue > 0 ? round(($item['revenue'] / $maxRevenue) * 100) : 0;
                        $pct = max($pct, 4);
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <span class="text-xs text-gray-500 font-medium">${{ $item['revenue'] > 0 ? number_format($item['revenue']) : '0' }}</span>
                            <div class="w-full rounded-t-lg bg-[#f09224] transition-all" style="height: {{ $pct }}%;"></div>
                            <span class="text-xs text-gray-400">{{ $item['month'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Top Subscription Plans --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-700 mb-5 uppercase tracking-wide flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Plans Ranking
                    </h2>
                    @if($topPlan->isEmpty())
                    <p class="text-sm text-gray-400">No active subscriptions yet.</p>
                    @else
                    @php $maxSubs = $topPlan->max('total_subs') ?: 1; @endphp
                    <div class="space-y-3">
                        @foreach($topPlan as $plan)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-medium text-gray-700 truncate max-w-[130px]">{{ $plan->name }}</span>
                                <span class="text-xs font-bold text-purple-600">{{ $plan->total_subs }} subs</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ round(($plan->total_subs / $maxSubs) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>

            {{-- ── Top Books ────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-sm font-bold text-gray-700 mb-5 uppercase tracking-wide flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#f09224]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Most Purchased Books
                </h2>
                @if($topBooks->isEmpty())
                <p class="text-sm text-gray-400">No purchase data yet.</p>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($topBooks as $i => $book)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-lg font-black text-gray-200 w-5 flex-shrink-0">#{{ $i + 1 }}</span>
                        @if($book->image && file_exists(public_path('storage/books/' . $book->image)))
                        <img src="{{ asset('storage/books/' . $book->image) }}" class="w-10 h-14 object-cover rounded shadow flex-shrink-0">
                        @else
                        <div class="w-10 h-14 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800 truncate">{{ $book->title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $book->total_sold }} sold</p>
                            <p class="text-xs text-[#f09224] font-bold">${{ number_format($book->total_revenue, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── Management Links ─────────────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                <a href="{{ route('news.management') }}"
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">News</p>
                        <p class="text-xs text-gray-400">Manage articles</p>
                    </div>
                    <span class="ml-auto text-gray-300 group-hover:text-blue-400 transition">&rarr;</span>
                </a>

                <a href="{{ route('admin.users') }}"
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Users</p>
                        <p class="text-xs text-gray-400">Manage accounts</p>
                    </div>
                    <span class="ml-auto text-gray-300 group-hover:text-green-400 transition">&rarr;</span>
                </a>

                <a href="{{ route('shop.management') }}"
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center group-hover:bg-orange-100 transition flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#f09224]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Shop</p>
                        <p class="text-xs text-gray-400">Manage catalog</p>
                    </div>
                    <span class="ml-auto text-gray-300 group-hover:text-orange-400 transition">&rarr;</span>
                </a>

                <a href="{{ route('plan.management') }}"
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Plans</p>
                        <p class="text-xs text-gray-400">Manage subscriptions</p>
                    </div>
                    <span class="ml-auto text-gray-300 group-hover:text-purple-400 transition">&rarr;</span>
                </a>

            </div>

            {{-- Footer --}}
            <div class="border-t border-gray-200 pt-4 flex flex-wrap gap-4 text-sm text-gray-400">
                <a href="{{ route('welcome') }}" class="hover:text-[#f09224] transition">← Back to site</a>
                <a href="{{ route('profile') }}" class="hover:text-[#f09224] transition">My Profile</a>
            </div>

        </div>
    </div>

</x-app>