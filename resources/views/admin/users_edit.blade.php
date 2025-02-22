<x-app>
    <x-slot:title>User - Edit</x-slot:title>
    <div class="m-[20px]">
        <h1 class="text-xl font-bold mb-6">Edit User</h1>
        <form action="{{ route('admin.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Img -->
            <div class="mb-4">
                <label for="img" class="block text-sm font-medium">Img</label>

                <div class="flex gap-4 flex-col max-w-[250px] items-center">

                    <div class="relative flex items-center justify-center">
                        <div class="w-[200px] h-[200px] rounded-full overflow-hidden bg-gray-200 shadow-2xl ring-2 ring-black ring-opacity-10 m-auto">

                            <img
                                id="profile-preview"
                                src="{{ $user->img && file_exists(public_path('storage/profilePhoto/' . $user->img)) ? asset('storage/profilePhoto/' . $user->img) : asset('assets/imgs/anakin-skywalker.webp') }}"
                                alt="Profile image" class="h-full w-full object-cover">

                        </div>
                    </div>

                    <div class="mt-4 flex items-center  text-sm leading-6 text-gray-600">
                        <label for="img" class="relative flex items-center justify-center cursor-pointer w-[150px] h-[40px] rounded-md bg-white font-semibold text-black focus-within:outline-none focus-within:ring-2 focus-within:ring-black focus-within:ring-offset-2 hover:text-black">
                            <span>Upload a file</span>
                            <input id="img" name="img" type="file" class="sr-only" accept="image/*">
                        </label>
                    </div>

                </div>

            </div>

            <!-- Subscription -->
            <div class="mb-4">
                <label for="subscription" class="block text-sm font-medium">Subscription</label>

                <select name="subscription" id="subscription" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="" data-description="No hay una descripción" {{ is_null($user->subscription) ? 'selected' : '' }}>No subscription</option>
                    @foreach($book_plans as $book_plan)
                    <option value="{{ $book_plan->book_plan_id }}" data-description="{{ $book_plan->description }}"
                        {{ $user->subscription && $user->subscription->bookPlan->book_plan_id == $book_plan->book_plan_id ? 'selected' : '' }}>
                        {{ $book_plan->name }} - ${{ $book_plan->total_price }}/month
                    </option>
                    @endforeach
                </select>

                <!-- Contenedor para la descripción -->
                <div id="plan-description" class="mt-2 text-gray-600">No hay una descripción</div>

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

<script>
    document.getElementById('img').addEventListener('change', function(event) {
        const file = event.target.files[0];
        // Obtiene el archivo seleccionado
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result; // Actualiza la imagen con la vista previa
            };
            reader.readAsDataURL(file);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const select = document.getElementById("subscription");
        const descriptionDiv = document.getElementById("plan-description");

        function updateDescription() {
            const selectedOption = select.options[select.selectedIndex];
            descriptionDiv.textContent = selectedOption.getAttribute("data-description") || "No hay una descripción";
        }

        select.addEventListener("change", updateDescription);

        // Inicializar la descripción al cargar la página
        updateDescription();
    });
</script>