<?php

/** @var \App\Models\BookPlan $plans */ ?>

<x-app>
    <x-slot:title>Plan Management</x-slot:title>

    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-5xl mx-auto">

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
                        <h1 class="text-2xl font-bold text-gray-900">Plan Management</h1>
                        <p class="text-sm text-gray-500">{{ $plans->count() }} subscription plans</p>
                    </div>
                </div>
                <a href="{{ route('plan.create') }}"
                    class="inline-flex items-center gap-2 bg-[#f09224] hover:bg-[#fcba50] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Plan
                </a>
            </div>

            {{-- Feedback --}}
            @if(session('feedback.message'))
            <div class="mb-5 p-4 bg-orange-50 border border-orange-200 text-orange-800 rounded-xl text-sm">
                {!! session('feedback.message') !!}
            </div>
            @endif

            {{-- Cards --}}
            @if($plans->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center text-gray-400 text-sm">
                No subscription plans yet. Create one to get started.
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($plans as $plan)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col overflow-hidden hover:shadow-md hover:border-[#f09224] transition-all duration-200">

                    {{-- Gradient header --}}
                    <div class="bg-gradient-to-br from-[#f09224] to-[#fcba50] p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-white text-xs font-semibold uppercase tracking-widest opacity-80 mb-1">Subscription</p>
                                <h2 class="text-white text-xl font-black leading-tight truncate">{{ $plan->name }}</h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-xl p-2 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-black mt-4">
                            ${{ $plan->total_price }}<span class="text-sm font-medium opacity-75">/mo</span>
                        </p>
                    </div>

                    {{-- Description --}}
                    <div class="p-5 flex-1">
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">{{ $plan->description }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="px-5 pb-5 flex gap-2 border-t border-gray-50 pt-4">
                        <a href="{{ route('plan.detail', ['id' => $plan->book_plan_id]) }}"
                            class="flex-1 inline-flex justify-center items-center py-2 rounded-xl text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            View
                        </a>
                        <a href="{{ route('plan.edit', ['id' => $plan->book_plan_id]) }}"
                            class="flex-1 inline-flex justify-center items-center py-2 rounded-xl text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                            Edit
                        </a>
                        <a href="{{ route('plan.delete', ['id' => $plan->book_plan_id]) }}"
                            class="flex-1 inline-flex justify-center items-center py-2 rounded-xl text-xs font-semibold bg-red-50 text-red-700 hover:bg-red-100 transition">
                            Delete
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>

</x-app>