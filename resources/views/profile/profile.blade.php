<x-app>
    <x-slot:title>Profile</x-slot:title>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg m-[20px]">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Information') }}
                            </h2>
                        </header>

                        <div class="flex flex-col sm:flex-row">

                            <div class="flex gap-4 flex-col max-w-[250px] items-center">

                                <div class="relative flex items-center justify-center">
                                    <div class="w-[200px] h-[200px] rounded-full overflow-hidden bg-gray-200 shadow-2xl ring-2 ring-black ring-opacity-10 m-auto">

                                        @if($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))

                                        <img src="{{ asset('storage/profilePhoto/' . $user->img) }}" alt="Profile image" class="h-full w-full object-cover">

                                        @else

                                        <img src="{{ asset('assets/imgs/anakin-skywalker.webp') }}" alt="Profile image"
                                            class="h-full w-full object-cover">

                                        @endif

                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="mt-6 space-y-4">
                            <p class="mt-1 text-sm text-gray-600"><strong>{{ __('Name:') }}</strong> {{ $user->name }}</p>
                            <p class="mt-1 text-sm text-gray-600"><strong>{{ __('Email:') }}</strong> {{ $user->email }}</p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                {{ __('Edit Profile') }}
                            </a>
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg m-[20px]">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Subscription Information') }}
                            </h2>
                        </header>

                        <div class="mt-6 space-y-4">
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
                                @endif
                            </p>
                        </div>

                        <div class="mt-6">
                            <button id="openSubscriptionModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                {{ __('Edit Subscription') }}
                            </button>
                        </div>

                        <div class="mt-6">
                            <button id="openCancelModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                {{ __('Cancel Subscription') }}
                            </button>
                        </div>

                    </section>
                </div>
            </div>

            <!-- Modal de edición de suscripción -->
            <div id="subscriptionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden pt-0 mt-0 space-y-0">
                <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Subscription</h2>

                    <!-- Formulario de suscripción -->
                    <form action="{{ route('profile.subscription.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="subscription" class="block text-sm font-medium text-gray-700">Select a Plan</label>
                        <select name="subscription" id="subscription" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="" data-description="No hay una descripción" {{ is_null($user->subscription) ? 'selected' : '' }}>
                                No subscription
                            </option>
                            @foreach($book_plans as $book_plan)
                            <option value="{{ $book_plan->book_plan_id }}" data-description="{{ $book_plan->description }}"
                                {{ $user->subscription && $user->subscription->bookPlan->book_plan_id == $book_plan->book_plan_id ? 'selected' : '' }}>
                                {{ $book_plan->name }} - ${{ $book_plan->total_price }}/month
                            </option>
                            @endforeach
                        </select>

                        <div class="mt-4 flex justify-between">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                Change Subscription
                            </button>

                            <button type="button" id="closeSubscriptionModal" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal de confirmación para cancelar suscripción -->
            <div id="cancelSubscriptionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Are you sure you want to cancel your subscription?</h2>

                    <div class="mt-4 flex justify-between">
                        <form action="{{ route('profile.subscription.cancel') }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                Confirm
                            </button>
                        </form>

                        <button type="button" id="closeCancelModal" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>


            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg m-[20px]">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Purchases Information') }}
                            </h2>
                        </header>

                        <h3 class="text-[16px] font-medium text-gray-900">
                            {{ __('Last Purchase') }}
                        </h3>

                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                {{ __('See Purchases History') }}
                            </a>
                        </div>

                    </section>
                </div>
            </div>



        </div>
    </div>

    <!-- Script para manejar el modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalBtn = document.getElementById('openSubscriptionModal');
            const closeModalBtn = document.getElementById('closeSubscriptionModal');
            const modal = document.getElementById('subscriptionModal');

            const openCancelModalBtn = document.getElementById('openCancelModal');
            const closeCancelModalBtn = document.getElementById('closeCancelModal');
            const cancelSubscriptionModal = document.getElementById('cancelSubscriptionModal');

            //Modal de edit subscription

            openModalBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Cierra el modal si el usuario hace clic fuera de él
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });

            //Modal de cancel subscription

            openCancelModalBtn.addEventListener('click', function() {
                cancelSubscriptionModal.classList.remove('hidden');
            });

            closeCancelModalBtn.addEventListener('click', function() {
                cancelSubscriptionModal.classList.add('hidden');
            });

            // Cierra el modal si el usuario hace clic fuera de él
            cancelSubscriptionModal.addEventListener('click', function(event) {
                if (event.target === cancelSubscriptionModal) {
                    cancelSubscriptionModal.classList.add('hidden');
                }
            });

        });
    </script>

</x-app>