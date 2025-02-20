<x-app>
    <x-slot:title>Profile</x-slot:title>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Information') }}
                            </h2>
                            <!-- <p class="mt-1 text-sm text-gray-600"> {{ __("Here is your profile information.") }} </p> -->
                        </header>

                        <div class="flex flex-col sm:flex-row">

                            <div class="flex gap-4 flex-col max-w-[250px] items-center">

                                <div class="relative flex items-center justify-center">
                                    <!-- <div class="w-[200px] h-[200px] rounded-full overflow-hidden bg-gray-200 shadow-2xl ring-2 ring-black ring-opacity-10 m-auto">
                                        <img src="{{ asset('assets/imgs/anakin-skywalker.webp') }}" alt="Profile image"
                                            class="h-full w-full object-cover">
                                    </div> -->

                                    
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url('profilePhoto/sGENQZkgojRmujof8uQ2bEU2w5id0JQfhyarx7rm.png') }}" alt="card-image" class="object-cover w-full h-full" />



                                </div>
                            </div>

                        </div>


                        <div class="mt-6 space-y-4">
                            <p class="mt-1 text-sm text-gray-600"><strong>{{ __('Name:') }}</strong> {{ $user->name }}</p>
                            <p class="mt-1 text-sm text-gray-600"><strong>{{ __('Email:') }}</strong> {{ $user->email }}</p>
                            <p class="mt-1 text-sm text-gray-600">
                                @if($user->subscription)
                                {{ 'Subscription Plan: ' . $user->subscription->bookPlan->name ?? 'No plan name' }} (until {{ $user->subscription->end_date }})
                                @else
                                No subscription
                                @endif
                            </p>
                            <p class="mt-1 text-sm text-gray-600">
                                @if($user->subscription)
                                {{ 'Plan Description: ' . $user->subscription->bookPlan->description ?? 'No plan description' }}
                                @else
                                No subscription description
                                @endif
                            </p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                {{ __('See Purchases History') }}
                            </a>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                {{ __('Edit Profile') }}
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app>