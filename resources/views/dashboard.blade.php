<x-app>
    <x-slot:title>Dashboard</x-slot:title>
    <h1 class="text-3xl font-bold text-center mb-8">Dashboard</h1>

    <div class="m-[20px]">

        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card for News Management -->
            <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col items-center justify-center">
                <h2 class="text-xl font-semibold mb-4">News Management</h2>
                <p class="text-gray-600 mb-6">Manage, create, edit, and delete news articles.</p>
                <a href="{{ route('news.management') }}" class="bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition duration-300">
                    Go to News Management
                </a>
            </div>

            <!-- Card for User Management -->
            <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col items-center justify-center">
                <h2 class="text-xl font-semibold mb-4">User Management</h2>
                <p class="text-gray-600 mb-6">View and manage registered users.</p>
                <a href="{{ route('admin.users') }}" class="bg-green-600 text-white rounded-md py-2 px-4 hover:bg-green-700 transition duration-300">
                    Go to User Management
                </a>
            </div>

            <!-- Card for Shop Management -->
            <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col items-center justify-center">
                <h2 class="text-xl font-semibold mb-4">Shop Management</h2>
                <p class="text-gray-600 mb-6">Manage, create, edit, and delete shop items.</p>
                <a href="{{ route('shop.management') }}" class="bg-red-600 text-white rounded-md py-2 px-4 hover:bg-red-700 transition duration-300">
                    Go to Shop Management
                </a>
            </div>

        </div>



    </div>

</x-app>