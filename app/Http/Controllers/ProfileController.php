<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SubscriptionUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\BookPlan;
use App\Models\Subscription;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function profile(Request $request): View
    {
        $user = $request->user()->load('subscription.bookPlan');
        $book_plans = BookPlan::all();
        return view('profile.profile', compact('user', 'book_plans'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        if ($request->filled('email') && trim($request->email) !== trim($user->email)) {
            $user->email = strtolower(trim($request->email));
            $user->email_verified_at = null;
        }

        // Shipping fields (nullable — se guardan aunque vengan vacíos para permitir borrar)
        $user->phone    = $request->input('phone');
        $user->address  = $request->input('address');
        $user->city     = $request->input('city');
        $user->province = $request->input('province');
        $user->zip_code = $request->input('zip_code');

        // Profile photo
        $oldImage = $user->img;
        if ($request->hasFile('img')) {
            $image     = $request->file('img');
            $imageName = $image->hashName();
            $image->storeAs('profilePhoto', $imageName, 'public');
            $user->img = $imageName;
            if ($oldImage && file_exists(public_path('storage/profilePhoto/' . $oldImage))) {
                unlink(public_path('storage/profilePhoto/' . $oldImage));
            }
        }

        $user->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

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

    public function updateSubscription(Request $request): RedirectResponse
    {
        $request->validate([
            'subscription' => 'nullable|exists:book_plans,book_plan_id',
        ]);

        $user = Auth::user();
        $currentSubscription = $user->subscription;

        if ($request->subscription) {
            $bookPlan = BookPlan::findOrFail($request->subscription);
            if ($currentSubscription) {
                $currentSubscription->update([
                    'book_plan_fk' => $bookPlan->book_plan_id,
                    'start_date'   => Carbon::now(),
                    'end_date'     => Carbon::now()->addMonth(),
                ]);
            } else {
                $subscription = Subscription::create([
                    'start_date'   => Carbon::now(),
                    'end_date'     => Carbon::now()->addMonth(),
                    'is_active'    => true,
                    'book_plan_fk' => $bookPlan->book_plan_id,
                ]);
                SubscriptionUser::create([
                    'subscription_fk' => $subscription->subscription_id,
                    'user_fk'         => $user->user_id,
                ]);
            }
        } else {
            if ($currentSubscription) {
                $this->deleteSubscription($currentSubscription, $user->user_id);
            }
        }

        return redirect()->route('profile')->with('success', 'Subscription updated successfully!');
    }

    public function cancelSubscription(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user->subscription) {
            $this->deleteSubscription($user->subscription, $user->user_id);
        }
        return redirect()->route('profile')->with('success', 'Subscription cancelled successfully!');
    }

    private function deleteSubscription(Subscription $subscription, int $userId): void
    {
        SubscriptionUser::where('subscription_fk', $subscription->subscription_id)
            ->where('user_fk', $userId)
            ->delete();

        if (SubscriptionUser::where('subscription_fk', $subscription->subscription_id)->count() === 0) {
            $subscription->delete();
        }
    }
}