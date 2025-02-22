<x-app>
    <x-slot:title>Users</x-slot:title>

    @if (session('success'))
    <div class="bg-green-500 text-white p-4 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-500 text-white p-4 mb-4 rounded">
        {{ session('error') }}
    </div>
    @endif

    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4 text-black">User list</h2>


        <div class="mb-4">
            <a href="{{ route('admin.create') }}"
                class="bg-black text-white px-4 py-2 hover:text-[#f09224] hover:bg-white rounded-lg focus:ring-4 focus:outline-none focus:ring-orange-300">
                Create New User
            </a>
        </div>

        <div class="w-full">
            <table class=" bg-white border border-gray-200 m-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">ID</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">Img</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">Name</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">Email</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">Role</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">Subscription</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="py-2 px-4 border-b text-sm">{{ $user->user_id }}</td>
                        <td class="py-2 px-4 border-b text-sm">
                            @if($user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)))
                            <img src="{{ asset('storage/profilePhoto/' . $user->img) }}" alt="Profile image" class="h-8 w-8 rounded-full">
                            @else
                            <img src="{{ asset('assets/imgs/anakin-skywalker.webp') }}" alt="Profile image"
                                class="h-8 w-8 rounded-full">
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-sm">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b text-sm">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b text-sm">{{ $user->role_id === 1 ? 'Admin' : 'User' }}</td>
                        <td class="py-2 px-4 border-b text-sm">
                            @if($user->subscription)
                            {{ $user->subscription->bookPlan->name ?? 'No plan name' }} (until {{ $user->subscription->end_date }})
                            @else
                            No subscription
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            @if($user->role_id === 2)
                            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0">
                                <a href="{{ route('admin.edit', $user->user_id) }}"
                                    class="w-full sm:w-auto h-[40px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Edit
                                </a>
                                <button type="button"
                                    class="w-full sm:w-auto h-[40px] inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 open-modal"
                                    data-id="{{ $user->user_id }}">
                                    Delete
                                </button>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

    <!-- Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-lg font-bold mb-4 text-black">Confirm Delete</h2>
            <p class="mb-4 text-black">Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <!-- Botón Cancelar -->
                <button id="cancelDelete"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <!-- Botón Confirmar -->
                <button id="confirmDelete"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Confirm
                </button>
            </div>
        </div>
    </div>

</x-app>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('deleteModal');
        const confirmButton = document.getElementById('confirmDelete');
        const cancelButton = document.getElementById('cancelDelete');
        let userIdToDelete = null;

        // Abrir modal
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', (e) => {
                userIdToDelete = e.target.getAttribute('data-id'); // Captura el ID del usuario
                modal.classList.remove('hidden'); // Muestra el modal
            });
        });

        // Cerrar modal al cancelar
        cancelButton.addEventListener('click', () => {
            userIdToDelete = null; // Resetea el ID del usuario
            modal.classList.add('hidden'); // Oculta el modal
        });

        // Confirmar eliminación
        confirmButton.addEventListener('click', () => {
            if (userIdToDelete) {
                // Crea un formulario y lo envía
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `../admin/users/${userIdToDelete}`;

                // Agrega el token CSRF y el método DELETE
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);

                form.submit(); // Envía el formulario
            }
        });
    });
</script>