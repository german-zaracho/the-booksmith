<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\BookPlan;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile info.
     */
    public function profile(Request $request): View
    {
        // return view('profile.profile', [
        //     'user' => $request->user(),
        // ]);

        // $user = $request->user()->load('subscription'); // Carga la relación de suscripción
        // return view('profile.profile', compact('user'));

        $user = $request->user()->load('subscription.bookPlan'); // Cargar la relación completa

        // Obtener todos los planes de libros
        $book_plans = BookPlan::all();

        return view('profile.profile', compact('user', 'book_plans'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        // $user->fill($request->validated());

        // Actualizar nombre si se proporciona
        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        // if ($user->isDirty('email')) {
        //     $user->email_verified_at = null;
        // }

        // Actualizar email solo si es diferente al actual
        if ($request->filled('email') && trim($request->email) !== trim($user->email)) {
            $user->email = strtolower(trim($request->email)); // Normalizar el email
            $user->email_verified_at = null;
        }

        // Guardar la imagen actual antes de actualizar
        $oldImage = $user->img;

        // so we can store images
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = $image->hashName(); // Genera un nombre aleatorio
            $image->storeAs('profilePhoto', $imageName, 'public'); // Guarda en storage

            $user->img = $imageName; // Guarda solo el nombre de la imagen en la base de datos

            if ($oldImage && file_exists(public_path('storage/profilePhoto/' . $oldImage))) {
                unlink(public_path('storage/profilePhoto/' . $oldImage));
            }
        }

        $user->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
        return Redirect::route('profile.edit')
            ->withErrors([]) // Borra errores de validación previos
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update user's subscription.
     */
    public function updateSubscription(Request $request)
    {
        $request->validate([
            'subscription' => 'nullable|exists:book_plans,book_plan_id',
        ]);

        $user = Auth::user();

        // Verificar si el usuario ya tiene una suscripción
        $currentSubscription = $user->subscription;

        if ($request->subscription) {
            // Si el usuario elige un nuevo plan
            $bookPlan = BookPlan::findOrFail($request->subscription);

            if ($currentSubscription) {
                // Actualizar la suscripción existente
                $currentSubscription->update([
                    'book_plan_fk' => $bookPlan->book_plan_id,
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addMonth(),
                ]);
            } else {
                // Crear una nueva suscripción si el usuario no tenía ninguna
                $subscription = Subscription::create([
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addMonth(),
                    'is_active' => true,
                    'book_plan_fk' => $bookPlan->book_plan_id,
                ]);

                SubscriptionUser::create([
                    'subscription_fk' => $subscription->subscription_id,
                    'user_fk' => $user->user_id,
                ]);
            }
        } else {
            // Si el usuario selecciona "No subscription", eliminar la suscripción
            if ($currentSubscription) {
                $currentSubscription->delete();
            }
        }

        return redirect()->route('profile')->with('success', 'Subscription updated successfully!');
    }
    
}
