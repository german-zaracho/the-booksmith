<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Buy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        $orders = DB::table('orders_has_users')
            ->where('orders_has_users.user_fk', Auth::id())
            ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
            ->leftJoin('books', 'order_books.book_fk', '=', 'books.book_id')
            ->whereNull('order_books.buy_fk')
            ->select(
                'order_books.order_book_id',
                'order_books.quantity',
                'order_books.price',
                'books.title',
                'books.author',
                'books.image'
            )
            ->get();

        return view('cart.cart', compact('orders'));
    }

    public function addToCart($bookId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add items to your cart.');
        }

        $book = Book::findOrFail($bookId);

        $existing = DB::table('orders_has_users')
            ->where('orders_has_users.user_fk', Auth::id())
            ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
            ->where('order_books.book_fk', $book->book_id)
            ->whereNull('order_books.buy_fk')
            ->select('order_books.order_book_id', 'order_books.quantity')
            ->first();

        if ($existing) {
            Order::where('order_book_id', $existing->order_book_id)
                ->update(['quantity' => $existing->quantity + 1]);
            return redirect()->back()->with('cart_added', $book->title);
        }

        $order = Order::create([
            'quantity' => 1,
            'price'    => $book->price,
            'book_fk'  => $book->book_id,
            'buy_fk'   => null,
        ]);

        DB::table('orders_has_users')->insert([
            'order_book_fk' => $order->order_book_id,
            'user_fk'       => Auth::id(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->back()->with('cart_added', $book->title);
    }

    // Devuelve JSON — llamado via fetch() desde el blade
    public function incrementQuantity($orderBookId)
    {
        $this->authorizeCartItem($orderBookId);
        Order::where('order_book_id', $orderBookId)->increment('quantity');
        return response()->json(['ok' => true]);
    }

    // Devuelve JSON — llamado via fetch() desde el blade
    public function decrementQuantity($orderBookId)
    {
        $this->authorizeCartItem($orderBookId);
        $order = Order::findOrFail($orderBookId);

        if ($order->quantity <= 1) {
            DB::table('orders_has_users')
                ->where('order_book_fk', $orderBookId)
                ->where('user_fk', Auth::id())
                ->delete();
            $order->delete();
            return response()->json(['ok' => true, 'removed' => true]);
        }

        $order->decrement('quantity');
        return response()->json(['ok' => true]);
    }

    // Devuelve JSON — llamado via fetch() desde el blade
    public function removeFromCart($orderBookId)
    {
        $this->authorizeCartItem($orderBookId);

        DB::table('orders_has_users')
            ->where('order_book_fk', $orderBookId)
            ->where('user_fk', Auth::id())
            ->delete();

        Order::where('order_book_id', $orderBookId)->delete();

        return response()->json(['ok' => true]);
    }

    // Finaliza la compra: crea un Buy, asocia las orders, limpia el carrito
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $cartItems = DB::table('orders_has_users')
            ->where('orders_has_users.user_fk', $user->user_id)
            ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
            ->whereNull('order_books.buy_fk')
            ->select('order_books.order_book_id', 'order_books.price', 'order_books.quantity')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($i) => $i->price * $i->quantity);

        $buy = Buy::create([
            'total_price' => $total,
            'date'        => now()->toDateString(),
            'status_fk'   => null,
        ]);

        DB::table('buys_has_users')->insert([
            'buy_fk'     => $buy->buy_id,
            'user_fk'    => $user->user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($cartItems as $item) {
            Order::where('order_book_id', $item->order_book_id)
                ->update(['buy_fk' => $buy->buy_id]);
        }

        DB::table('orders_has_users')
            ->where('user_fk', $user->user_id)
            ->whereIn('order_book_fk', $cartItems->pluck('order_book_id'))
            ->delete();

        return redirect()->route('cart')->with('success', 'Purchase completed successfully! 🎉');
    }

    public function orderHistory()
    {
        $buys = DB::table('buys_has_users')
            ->where('buys_has_users.user_fk', Auth::id())
            ->join('buys', 'buys_has_users.buy_fk', '=', 'buys.buy_id')
            ->leftJoin('status', 'buys.status_fk', '=', 'status.status_id')
            ->select('buys.buy_id', 'buys.total_price', 'buys.date', 'status.name as status_name')
            ->orderByDesc('buys.date')
            ->get();

        $history = $buys->map(function ($buy) {
            $buy->items = DB::table('order_books')
                ->where('order_books.buy_fk', $buy->buy_id)
                ->leftJoin('books', 'order_books.book_fk', '=', 'books.book_id')
                ->select('order_books.quantity', 'order_books.price', 'books.title', 'books.author', 'books.image')
                ->get();
            return $buy;
        });

        return view('cart.order_history', compact('history'));
    }

    private function authorizeCartItem($orderBookId): void
    {
        $exists = DB::table('orders_has_users')
            ->where('order_book_fk', $orderBookId)
            ->where('user_fk', Auth::id())
            ->exists();

        if (!$exists) abort(403);
    }
}