<x-app>
    <x-slot:title>Users</x-slot:title>
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4 text-black">User list</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Rol</th>
                    <th class="py-2 px-4 border-b">Subscription</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->user_id }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->role_id === 1 ? 'Admin' : 'User' }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($user->subscription)
                        {{ $user->subscription->bookPlan->name ?? 'No plan name' }} (until {{ $user->subscription->end_date }})
                        @else
                        No subscription
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app>