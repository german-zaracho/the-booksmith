<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    // public function index()
    // {
    //     $users = User::with(['subscription.bookPlan'])->get(); // Carga la suscripción y su plan asociado
    //     return view('admin.users', compact('users'));
    // }

    public function index()
{
    $users = User::with([
        'subscription.bookPlan',
    ])->get();

    // Load purchase history with book details for each user
    $users->each(function ($user) {
        $purchases = DB::table('buys_has_users')
            ->where('buys_has_users.user_fk', $user->user_id)
            ->join('buys', 'buys_has_users.buy_fk', '=', 'buys.buy_id')
            ->leftJoin('status', 'buys.status_fk', '=', 'status.status_id')
            ->select(
                'buys.buy_id',
                'buys.total_price',
                'buys.date',
                'buys.payment_method',
                'status.name as status_name'
            )
            ->orderByDesc('buys.date')
            ->get();

        // For each purchase, load the books
        $purchases->each(function ($purchase) {
            $purchase->items = DB::table('order_books')
                ->where('order_books.buy_fk', $purchase->buy_id)
                ->leftJoin('books', 'order_books.book_fk', '=', 'books.book_id')
                ->select(
                    'books.title',
                    'books.image',
                    'order_books.quantity',
                    'order_books.price'
                )
                ->get();
        });

        $user->purchaseHistory = $purchases;
    });

    return view('admin.users', compact('users'));
}

    // Método para crear un nuevo usuario
    // public function createNewUser()
    // {
    //     // Obtener el último ID de usuario existente
    //     $lastId = User::max('user_id');
    //     $newId = $lastId ? $lastId + 1 : 2; // Si no hay usuarios, inicia en 2

    //     // Crear el nuevo usuario
    //     $user = User::create([
    //         'user_id' => $newId,
    //         'name' => $newId . 'username',
    //         'email' => $newId . 'new@user.com',
    //         'password' => bcrypt('asdasd12'), // Generar una contraseña segura
    //         'role_id' => 2, // Rol de usuario común
    //     ]);

    //     return redirect()->route('admin.users')->with('success', 'New user created successfully!');
    // }

    public function createNewUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|string',
        ]);

        $lastId = User::max('user_id');
        $newId = $lastId ? $lastId + 1 : 2;

        User::create([
            'user_id' => $newId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
        ]);

        return redirect()->route('admin.users')->with('success', 'New user created successfully!');
    }

    public function getNewUserDefaults()
    {
        $lastId = User::max('user_id');
        $newId = $lastId ? $lastId + 1 : 2;

        return response()->json([
            'name' => $newId . 'username',
            'email' => $newId . 'new@user.com',
            'password' => 'asdasd12' // Se enviará sin encriptar para mostrarlo en el form
        ]);
    }

    public function store(Request $request)
    {
        return $this->createNewUser($request);
    }

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Solo permite eliminar si el role_id es 2
        if ($user->role_id !== 2) {
            return redirect()->route('admin.users')->with('error', 'Cannot delete this user.');
        }

        $userImage = $user->img;

        // Obtener todas las suscripciones del usuario
        $subscriptionIds = SubscriptionUser::where('user_fk', $user->user_id)->pluck('subscription_fk');

        // Eliminar las relaciones en la tabla subscriptions_has_users
        SubscriptionUser::where('user_fk', $user->user_id)->delete();

        // Eliminar las suscripciones en la tabla subscriptions
        Subscription::whereIn('subscription_id', $subscriptionIds)->delete();

        $user->delete();

        if ($userImage && file_exists(public_path('storage/profilePhoto/' . $userImage))) {
            unlink(public_path('storage/profilePhoto/' . $userImage));
        }

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function edit($id)
    {

        $user = User::with('subscription')->findOrFail($id);
        $book_plans = Plan::all(); // Obtener todos los planes disponibles
        return view('admin.users_edit', compact('user', 'book_plans'));
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => bcrypt('asdasd12')]);

        return redirect()->route('admin.edit', $user->user_id)->with('success', 'Password reset successfully.');
    }

    // public function update(Request $request, $id)
    // {

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:users,email,' . $id . ',user_id',
    //         'img' => 'nullable|image|max:2048',
    //         'subscription' => 'nullable|exists:book_plans,book_plan_id', // Validar que el plan seleccionado sea válido
    //     ]);

    //     $user = User::findOrFail($id);

    //     $oldImage = $user->img;

    //     // Si se sube una nueva imagen
    //     if ($request->hasFile('img')) {
    //         $image = $request->file('img');
    //         $imageName = $image->hashName(); // Genera un nombre aleatorio
    //         $image->storeAs('profilePhoto', $imageName, 'public'); // Guarda en storage

    //         $user->img = $imageName; // Guarda solo el nombre de la imagen en la base de datos

    //         // Eliminar la imagen anterior si existe
    //         if ($oldImage && file_exists(public_path('storage/profilePhoto/' . $oldImage))) {
    //             unlink(public_path('storage/profilePhoto/' . $oldImage));
    //         }
    //     }

    //     $user->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'img' => $user->img,
    //     ]);

    //     // Verificamos si el usuario tiene una suscripción actual
    //     // if ($request->has('subscription')) {
    //     //     if ($user->subscription) {
    //     //         // Si el usuario tiene una suscripción existente, actualizamos el plan
    //     //         $user->subscription->update(['book_plan_fk' => $request->subscription]);
    //     //     } else {
    //     //         // Si el usuario no tiene una suscripción, creamos una nueva suscripción
    //     //         $newSubscription = Subscription::create([
    //     //             'start_date' => Carbon::now(),
    //     //             'end_date' => Carbon::now()->addMonth(),
    //     //             'is_active' => true,
    //     //             'book_plan_fk' => $request->subscription,
    //     //         ]);

    //     //         // Asociamos el usuario con la nueva suscripción
    //     //         SubscriptionUser::create([
    //     //             'subscription_fk' => $newSubscription->subscription_id,
    //     //             'user_fk' => $user->user_id,
    //     //         ]);
    //     //     }
    //     // }

    //     if ($request->has('subscription')) {
    //         if ($request->subscription === null) {
    //             // Si se seleccionó "No subscription / Cancel Subscription", eliminamos la suscripción
    //             if ($user->subscription) {
    //                 SubscriptionUser::where('user_fk', $user->user_id)->delete();
    //                 $user->subscription->delete();
    //             }
    //         } else {
    //             if ($user->subscription) {
    //                 // Si el usuario tiene una suscripción existente, la actualizamos
    //                 $user->subscription->update(['book_plan_fk' => $request->subscription]);
    //             } else {
    //                 // Si el usuario no tiene una suscripción, creamos una nueva
    //                 $newSubscription = Subscription::create([
    //                     'start_date' => Carbon::now(),
    //                     'end_date' => Carbon::now()->addMonth(),
    //                     'is_active' => true,
    //                     'book_plan_fk' => $request->subscription,
    //                 ]);

    //                 SubscriptionUser::create([
    //                     'subscription_fk' => $newSubscription->subscription_id,
    //                     'user_fk' => $user->user_id,
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    // }
public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',user_id',
        ]);

        $user = User::findOrFail($id);

        // ── Profile photo ─────────────────────────────────────────
        if ($request->hasFile('img')) {
            $oldImage = $user->img;
            $image     = $request->file('img');
            $imageName = $image->hashName();
            $image->storeAs('profilePhoto', $imageName, 'public');
            $user->img = $imageName;

            if ($oldImage && file_exists(public_path('storage/profilePhoto/' . $oldImage))) {
                unlink(public_path('storage/profilePhoto/' . $oldImage));
            }
        }

        // ── Basic info ────────────────────────────────────────────
        $user->name  = $request->name;
        $user->email = $request->email;

        // ── Shipping info (nullable — allows clearing fields) ─────
        $user->phone    = $request->input('phone');
        $user->address  = $request->input('address');
        $user->city     = $request->input('city');
        $user->province = $request->input('province');
        $user->zip_code = $request->input('zip_code');

        $user->save();

        // ── Subscription ──────────────────────────────────────────
        if ($request->has('subscription')) {
            if ($request->subscription === null || $request->subscription === '') {
                // Cancel subscription
                if ($user->subscription) {
                    SubscriptionUser::where('user_fk', $user->user_id)->delete();
                    $user->subscription->delete();
                }
            } else {
                if ($user->subscription) {
                    $user->subscription->update(['book_plan_fk' => $request->subscription]);
                } else {
                    $newSubscription = Subscription::create([
                        'start_date'   => Carbon::now(),
                        'end_date'     => Carbon::now()->addMonth(),
                        'is_active'    => true,
                        'book_plan_fk' => $request->subscription,
                    ]);

                    SubscriptionUser::create([
                        'subscription_fk' => $newSubscription->subscription_id,
                        'user_fk'         => $user->user_id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.edit', $user->user_id)->with('success', 'User updated successfully.');
    }
}
