<x-app>
    <x-slot:title>User - Edit</x-slot:title>
    <div class="m-[20px]">
        <h1 class="text-xl font-bold mb-6">Edit User</h1>
        <form action="{{ route('admin.update', $user->user_id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>


            <!-- Botón para confirmar -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Confirm Edit
                </button>
            </div>
        </form>
    </div>
</x-app>