<?php /** @var \App\Models\BookPlan $book_plans */ ?>

<x-app>
    <x-slot:title>Subscriptions</x-slot:title>

    {{-- Modal de confirmación de reemplazo --}}
    @auth
    @if($activeSub)
    <div id="replaceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Replace subscription?</h3>
                    <p class="text-sm text-gray-500">
                        Your current <strong>{{ $activeSub->bookPlan->name }}</strong> plan will be cancelled and replaced.
                    </p>
                </div>
            </div>
            <div class="flex gap-3 mt-5">
                <button id="cancelReplace"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form id="replaceForm" method="POST" action="" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold bg-[#f09224] text-white hover:bg-[#fcba50] transition">
                        Replace
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endauth

    <div class="min-h-screen bg-[#faf7f2] py-16 px-4">
        <div class="max-w-6xl mx-auto">

            {{-- Hero header --}}
            <div class="text-center mb-14">
                <p class="text-xs font-semibold uppercase tracking-widest text-[#f09224] mb-3">The Booksmith</p>
                <h1 class="text-5xl font-black text-gray-900 leading-tight mb-4">Choose Your Plan</h1>
                <p class="text-gray-500 text-lg max-w-xl mx-auto leading-relaxed">
                    Get curated books delivered to your door every month. Cancel anytime.
                </p>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
            <div class="max-w-lg mx-auto mb-8 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="max-w-lg mx-auto mb-8 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Banner suscripción activa --}}
            @auth
            @if($activeSub)
            <div class="max-w-lg mx-auto mb-10 p-4 bg-white border-2 border-[#f09224] rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-[#f09224] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">
                        Active plan: <span class="text-[#f09224]">{{ $activeSub->bookPlan->name }}</span>
                    </p>
                    <p class="text-xs text-gray-500">
                        Active until {{ \Carbon\Carbon::parse($activeSub->end_date)->format('M d, Y') }}
                    </p>
                </div>
            </div>
            @endif
            @endauth

            {{-- Plans grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
                @foreach($book_plans as $i => $book_plan)

                @php
                    $featured   = ($book_plans->count() >= 3 && $i == 1);
                    $isCurrent  = $activeSub && $activeSub->book_plan_fk == $book_plan->book_plan_id;
                @endphp

                <div class="relative flex flex-col rounded-3xl border
                    {{ $isCurrent ? 'border-[#f09224] ring-2 ring-[#f09224] ring-opacity-30' : ($featured ? 'border-[#f09224] shadow-2xl shadow-orange-100 scale-[1.03]' : 'border-[#ede8dd] shadow-sm') }}
                    bg-white overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">

                    @if($isCurrent)
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#f09224] to-[#fcba50]"></div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-[#f09224] text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                            Your plan
                        </span>
                    </div>
                    @elseif($featured)
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#f09224] to-[#fcba50]"></div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-[#f09224] text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                            Most popular
                        </span>
                    </div>
                    @endif

                    {{-- Plan header --}}
                    <div class="{{ $featured || $isCurrent ? 'pt-10 px-8 pb-6' : 'pt-7 px-7 pb-6' }}">
                        <h2 class="text-xl font-black text-gray-900 mb-1">{{ $book_plan->name }}</h2>
                        <div class="flex items-end gap-1 my-5">
                            <span class="text-5xl font-black {{ $featured || $isCurrent ? 'text-[#f09224]' : 'text-gray-900' }}">${{ $book_plan->total_price }}</span>
                            <span class="text-gray-400 text-sm mb-2">/month</span>
                        </div>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $book_plan->description }}</p>
                    </div>

                    <div class="mx-7 border-t border-gray-100"></div>

                    {{-- Features --}}
                    <div class="{{ $featured || $isCurrent ? 'px-8 py-6' : 'px-7 py-5' }} flex-1">
                        <ul class="space-y-3">
                            @foreach(['Monthly curated selection', 'Free shipping', 'Cancel anytime', 'Access to member community'] as $feature)
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <div class="w-5 h-5 rounded-full {{ $featured || $isCurrent ? 'bg-[#f09224]' : 'bg-green-100' }} flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 {{ $featured || $isCurrent ? 'text-white' : 'text-green-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- CTA --}}
                    <div class="{{ $featured || $isCurrent ? 'px-8 pb-8' : 'px-7 pb-7' }}">
                        @auth
                            @if($isCurrent)
                                {{-- Plan actual --}}
                                <div class="w-full text-center py-3 px-6 rounded-xl font-bold text-sm bg-[#faf7f2] text-[#f09224] border-2 border-[#f09224] cursor-default">
                                    ✓ Current plan
                                </div>
                            @elseif($activeSub)
                                {{-- Tiene otro plan — mostrar modal --}}
                                <button type="button"
                                        class="open-replace-modal w-full py-3 px-6 rounded-xl font-bold text-sm transition-all duration-200
                                               {{ $featured ? 'bg-[#f09224] hover:bg-[#fcba50] text-white shadow-lg shadow-orange-200' : 'bg-gray-900 hover:bg-gray-700 text-white' }}"
                                        data-action="{{ route('subscribe', $book_plan->book_plan_id) }}">
                                    Switch to this plan
                                </button>
                            @else
                                {{-- Sin suscripción --}}
                                <form action="{{ route('subscribe', $book_plan->book_plan_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full py-3 px-6 rounded-xl font-bold text-sm transition-all duration-200
                                                   {{ $featured ? 'bg-[#f09224] hover:bg-[#fcba50] text-white shadow-lg shadow-orange-200' : 'bg-gray-900 hover:bg-gray-700 text-white' }}">
                                        Subscribe now
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="block w-full text-center py-3 px-6 rounded-xl font-bold text-sm transition-all duration-200
                                      {{ $featured ? 'bg-[#f09224] hover:bg-[#fcba50] text-white' : 'bg-gray-900 hover:bg-gray-700 text-white' }}">
                                Log in to subscribe
                            </a>
                        @endauth
                    </div>

                </div>
                @endforeach
            </div>

            {{-- Guarantee --}}
            <div class="mt-14 text-center">
                <p class="text-sm text-gray-400 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#f09224]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    No commitments · Cancel anytime · Secure payments
                </p>
            </div>

        </div>
    </div>

    @auth
    @if($activeSub)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal       = document.getElementById('replaceModal');
            var replaceForm = document.getElementById('replaceForm');
            var cancelBtn   = document.getElementById('cancelReplace');

            document.querySelectorAll('.open-replace-modal').forEach(function(btn) {
                btn.addEventListener('click', function () {
                    replaceForm.action = btn.dataset.action;
                    modal.classList.remove('hidden');
                });
            });

            cancelBtn.addEventListener('click', function () { modal.classList.add('hidden'); });
            modal.addEventListener('click', function (e) {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });
    </script>
    @endif
    @endauth

</x-app>