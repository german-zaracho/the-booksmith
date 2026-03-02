<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookPlan;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class SubscriptionsController extends Controller
{
    public function subscriptions()
    {
        $plans   = BookPlan::all();
        $activeSub = null;

        if (Auth::check()) {
            $activeSub = Auth::user()->subscription;
            if ($activeSub) {
                $activeSub->load('bookPlan');
            }
        }

        return view('subscriptions', [
            'book_plans' => $plans,
            'activeSub'  => $activeSub,
        ]);
    }

    public function checkout($bookPlanId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to subscribe!');
        }

        $bookPlan = BookPlan::findOrFail($bookPlanId);
        $user     = Auth::user();

        if ($user->subscription && $user->subscription->book_plan_fk == $bookPlan->book_plan_id) {
            return redirect()->route('subscriptions')
                ->with('error', 'You already have an active subscription to this plan.');
        }

        $mpPublicKey    = env('MERCADOPAGO_PUBLIC_KEY');
        $mpPreferenceId = null;

        try {
            $mpPreferenceId = $this->createMPPreference($bookPlan);
        } catch (MPApiException $e) {
            Log::error('MP subscription preference failed', [
                'status'   => $e->getApiResponse()?->getStatusCode(),
                'response' => $e->getApiResponse()?->getContent(),
            ]);
        } catch (\Exception $e) {
            Log::error('MP subscription preference failed', ['error' => $e->getMessage()]);
        }

        $book_plan = $bookPlan;
        return view('subscription_checkout', compact('book_plan', 'mpPublicKey', 'mpPreferenceId'));
    }

    public function process(Request $request, $bookPlanId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to subscribe!');
        }

        $book_plan = BookPlan::findOrFail($bookPlanId);
        $bookPlan  = $book_plan;

        $request->validate([
            'payment_method' => 'required|in:credit_card',
            'card_name'      => 'required|string|min:3|max:100',
            'card_number'    => 'required|string|min:19|max:19',
            'card_expiry'    => 'required|string|size:5',
            'card_cvv'       => 'required|string|min:3|max:4',
        ]);

        $this->activateSubscription($bookPlan, 'credit_card', 'completed');

        return redirect()->route('profile')
            ->with('success', 'Subscription activated! Welcome to the ' . $bookPlan->name . ' plan.');
    }

    public function paymentSuccess(Request $request)
    {
        $ref = $request->query('external_reference', '');

        if (str_starts_with($ref, 'subscription_')) {
            $parts      = explode('_', $ref);
            $bookPlanId = $parts[1] ?? null;

            if ($bookPlanId) {
                $bookPlan = BookPlan::find($bookPlanId);
                if ($bookPlan) {
                    $this->activateSubscription($bookPlan);
                }
            }
        }

        return redirect()->route('profile')
            ->with('success', 'Subscription payment successful! Your plan is now active.');
    }

    public function paymentFailure(Request $request)
    {
        return redirect()->route('subscriptions')
            ->with('error', 'Payment failed or was cancelled. Please try again.');
    }

    public function paymentPending(Request $request)
    {
        return redirect()->route('profile')
            ->with('success', 'Your payment is pending. Your subscription will be activated once confirmed.');
    }

    private function activateSubscription(BookPlan $bookPlan, string $paymentMethod = 'mercadopago', string $status = 'completed'): void
    {
        $user      = Auth::user();
        $startDate = Carbon::now();
        $endDate   = $startDate->copy()->addMonth();

        $currentSubscription = $user->subscription;

        if ($currentSubscription) {
            $currentSubscription->update([
                'book_plan_fk'   => $bookPlan->book_plan_id,
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'is_active'      => true,
                'payment_method' => $paymentMethod,
                'payment_status' => $status,
            ]);
        } else {
            $subscription = Subscription::create([
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'is_active'      => true,
                'book_plan_fk'   => $bookPlan->book_plan_id,
                'payment_method' => $paymentMethod,
                'payment_status' => $status,
            ]);

            SubscriptionUser::create([
                'subscription_fk' => $subscription->subscription_id,
                'user_fk'         => $user->user_id,
            ]);
        }
    }

    private function createMPPreference(BookPlan $bookPlan): string
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $preferenceData = [
            'items' => [
                [
                    'id'          => 'subscription_' . $bookPlan->book_plan_id,
                    'title'       => 'TheBooksmith — ' . $bookPlan->name . ' Plan',
                    'quantity'    => 1,
                    'unit_price'  => (float) $bookPlan->total_price,
                    'currency_id' => 'ARS',
                ],
            ],
            'payer' => [
                'name'  => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'back_urls' => [
                'success' => route('subscription.payment.success'),
                'failure' => route('subscription.payment.failure'),
                'pending' => route('subscription.payment.pending'),
            ],
            'external_reference'   => 'subscription_' . $bookPlan->book_plan_id . '_' . Auth::id(),
            'statement_descriptor' => 'TheBooksmith',
        ];

        $client     = new PreferenceClient();
        $preference = $client->create($preferenceData);

        return $preference->id;
    }
}