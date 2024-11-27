<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\BookPlan;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionsController extends Controller
{
    public function subscriptions()
    {
        $plans = Plan::all();
        return view('subscriptions', [
            'book_plans' => $plans
        ]);
    }

    public function checkout($bookPlanId)
    {
        $bookPlan = BookPlan::findOrFail($bookPlanId);

        return view('checkout', [
            'book_plan' => $bookPlan,
        ]);
    }

    public function finalizeSubscription($bookPlanId)
    {
        // Asegurarse de que el usuario esté autenticado
        $user = Auth::user();

        // Obtener el plan de libros seleccionado
        $bookPlan = BookPlan::findOrFail($bookPlanId);

        // Crear la suscripción (dura 1 mes)
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonth();

        $subscription = Subscription::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
            'book_plan_fk' => $bookPlan->book_plan_id,
        ]);

        // Asociar la suscripción con el usuario en la tabla intermedia
        SubscriptionUser::create([
            'subscription_fk' => $subscription->subscription_id,
            'user_fk' => $user->user_id,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('subscriptions')->with('success', 'Subscription successful!');
    }
}