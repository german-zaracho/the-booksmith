<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class CheckoutController extends Controller
{
    const STATUS_PENDING   = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED  = 3;

    // ─────────────────────────────────────────────────────────────────
    // Show checkout page — also creates the MP preference so the
    // Wallet Brick can be rendered immediately
    // ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $orders = $this->getPendingOrders();

        if ($orders->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = $orders->sum(fn($o) => $o->price * $o->quantity);

        $mpPublicKey    = env('MERCADOPAGO_PUBLIC_KEY');
        $mpPreferenceId = null;

        // Pre-create the MP preference so the Wallet Brick works on page load
        try {
            $mpPreferenceId = $this->createMPPreference($orders);
        } catch (MPApiException $e) {
            Log::error('MP preference creation failed', [
                'status'   => $e->getApiResponse()?->getStatusCode(),
                'response' => $e->getApiResponse()?->getContent(),
                'message'  => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            Log::error('MP preference creation failed', ['error' => $e->getMessage()]);
        }

        return view('cart.checkout', compact('orders', 'total', 'mpPublicKey', 'mpPreferenceId'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Process the checkout form (shipping info + payment method)
    // ─────────────────────────────────────────────────────────────────
    public function process(Request $request)
    {
        $rules = [
            'full_name'      => 'required|string|min:3|max:100',
            'phone'          => 'required|string|min:7|max:30',
            'address'        => 'required|string|min:5|max:200',
            'city'           => 'required|string|min:2|max:100',
            'province'       => 'required|string|min:2|max:100',
            'zip_code'       => 'required|string|min:3|max:15',
            'payment_method' => 'required|in:mercadopago,credit_card',
        ];

        if ($request->payment_method === 'credit_card') {
            $rules['card_name']   = 'required|string|min:3|max:100';
            $rules['card_number'] = 'required|string|min:19|max:19';
            $rules['card_expiry'] = 'required|string|size:5';
            $rules['card_cvv']    = 'required|string|min:3|max:4';
        }

        $request->validate($rules, [
            'full_name.required'      => 'Please enter your full name.',
            'phone.required'          => 'Please enter your phone number.',
            'address.required'        => 'Please enter your shipping address.',
            'city.required'           => 'Please enter your city.',
            'province.required'       => 'Please enter your province/state.',
            'zip_code.required'       => 'Please enter your ZIP code.',
            'payment_method.required' => 'Please select a payment method.',
            'card_number.min'         => 'Please enter a valid 16-digit card number.',
            'card_expiry.size'        => 'Please enter a valid expiry date (MM/YY).',
            'card_cvv.min'            => 'CVV must be at least 3 digits.',
        ]);

        // Save shipping info to profile if requested
        if ($request->boolean('save_to_profile')) {
            /** @var User $user */
            $user = Auth::user();
            $user->phone    = $request->phone;
            $user->address  = $request->address;
            $user->city     = $request->city;
            $user->province = $request->province;
            $user->zip_code = $request->zip_code;
            $user->save();
        }

        session([
            'checkout_shipping' => $request->only(['full_name', 'phone', 'address', 'city', 'province', 'zip_code'])
        ]);

        // Credit card demo — process instantly
        if ($request->payment_method === 'credit_card') {
            return $this->processCreditCard();
        }

        // MercadoPago — redirect to MP with the wallet brick preference
        // (The preference was already created on index(), but we create a fresh one here
        //  to ensure it reflects any shipping updates)
        try {
            $orders         = $this->getPendingOrders();
            $preferenceId   = $this->createMPPreference($orders);
            $mpPublicKey    = env('MERCADOPAGO_PUBLIC_KEY');
            $total          = $orders->sum(fn($o) => $o->price * $o->quantity);
            $mpPreferenceId = $preferenceId;

            return view('cart.checkout', compact('orders', 'total', 'mpPublicKey', 'mpPreferenceId'));

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Error creating payment: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // Create MercadoPago preference and return its ID
    // ─────────────────────────────────────────────────────────────────
    private function createMPPreference($orders): string
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $shipping = session('checkout_shipping', []);

        $items = [];
        foreach ($orders as $order) {
            $items[] = [
                'id'          => (string) $order->order_book_id,
                'title'       => $order->title ?? 'Book',
                'quantity'    => (int) $order->quantity,
                'unit_price'  => (float) $order->price,
                'currency_id' => 'ARS',
            ];
        }

        $preferenceData = [
            'items'      => $items,
            'payer'      => [
                'name'  => $shipping['full_name'] ?? Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'back_urls'  => [
                'success' => route('payment.success'),
                'failure' => route('payment.failure'),
                'pending' => route('payment.pending'),
            ],
            // auto_return removed — requires public URL, not compatible with localhost
            'external_reference'   => 'user_' . Auth::id() . '_' . time(),
            'statement_descriptor' => 'TheBooksmith',
        ];

        $client     = new PreferenceClient();
        $preference = $client->create($preferenceData);

        return $preference->id;
    }

    // ─────────────────────────────────────────────────────────────────
    // Credit card demo — approve instantly
    // ─────────────────────────────────────────────────────────────────
    private function processCreditCard()
    {
        $orders = $this->getPendingOrders();

        if ($orders->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = $orders->sum(fn($o) => $o->price * $o->quantity);

        DB::transaction(function () use ($orders, $total) {
            $this->savePurchase($orders, $total, 'credit_card', self::STATUS_COMPLETED);
        });

        session()->forget('checkout_shipping');

        return redirect()->route('orders.history')
            ->with('success', 'Payment successful! Your order has been placed.');
    }

    // ─────────────────────────────────────────────────────────────────
    // MercadoPago callback: payment approved
    // ─────────────────────────────────────────────────────────────────
    public function paymentSuccess(Request $request)
    {
        $orders = $this->getPendingOrders();

        if ($orders->isNotEmpty()) {
            $total = $orders->sum(fn($o) => $o->price * $o->quantity);
            DB::transaction(function () use ($orders, $total) {
                $this->savePurchase($orders, $total, 'mercadopago', self::STATUS_COMPLETED);
            });
        }

        session()->forget('checkout_shipping');

        return redirect()->route('orders.history')
            ->with('success', 'Payment successful! Thank you for your purchase.');
    }

    // ─────────────────────────────────────────────────────────────────
    // MercadoPago callback: payment failed
    // ─────────────────────────────────────────────────────────────────
    public function paymentFailure(Request $request)
    {
        return redirect()->route('cart')
            ->with('error', 'Payment failed or was cancelled. Please try again.');
    }

    // ─────────────────────────────────────────────────────────────────
    // MercadoPago callback: payment pending
    // ─────────────────────────────────────────────────────────────────
    public function paymentPending(Request $request)
    {
        $orders = $this->getPendingOrders();

        if ($orders->isNotEmpty()) {
            $total = $orders->sum(fn($o) => $o->price * $o->quantity);
            DB::transaction(function () use ($orders, $total) {
                $this->savePurchase($orders, $total, 'mercadopago', self::STATUS_PENDING);
            });
        }

        session()->forget('checkout_shipping');

        return redirect()->route('orders.history')
            ->with('success', 'Your payment is pending. We will notify you once confirmed.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Save purchase to DB
    // ─────────────────────────────────────────────────────────────────
    private function savePurchase($orders, float $total, string $paymentMethod, int $statusId): void
    {
        $buy = Buy::create([
            'total_price'    => $total,
            'date'           => now()->toDateString(),
            'status_fk'      => $statusId,
            'payment_method' => $paymentMethod,
        ]);

        DB::table('buys_has_users')->insert([
            'buy_fk'     => $buy->buy_id,
            'user_fk'    => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderIds = $orders->pluck('order_book_id')->toArray();
        DB::table('order_books')
            ->whereIn('order_book_id', $orderIds)
            ->update(['buy_fk' => $buy->buy_id]);
    }

    // ─────────────────────────────────────────────────────────────────
    // Helper: pending cart items
    // ─────────────────────────────────────────────────────────────────
    private function getPendingOrders()
    {
        return DB::table('orders_has_users')
            ->where('orders_has_users.user_fk', Auth::id())
            ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
            ->leftJoin('books', 'order_books.book_fk', '=', 'books.book_id')
            ->whereNull('order_books.buy_fk')
            ->select(
                'order_books.order_book_id',
                'order_books.quantity',
                'order_books.price',
                'books.title',
                'books.image'
            )
            ->get();
    }
}