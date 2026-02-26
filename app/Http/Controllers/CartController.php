<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order; // Usar Order en lugar de Cart
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        // Mostrar el carrito (todas las órdenes asociadas al usuario)
        $orders = DB::table('orders_has_users')
                    ->where('user_fk', Auth::id()) // Filtrar por el usuario autenticado
                    ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
                    ->get();

        return view('cart.cart', compact('orders'));
    }

    public function addToCart($bookId)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add items to your cart.');
        }

        $user = Auth::user();

        // Obtener el libro por ID
        $book = Book::find($bookId);

        // Verificar si el usuario ya tiene órdenes de compra (carrito) en la tabla orders_has_users
        $existingOrder = DB::table('orders_has_users')
            ->where('user_fk', $user->user_id)
            ->join('order_books', 'orders_has_users.order_book_fk', '=', 'order_books.order_book_id')
            ->whereNull('order_books.order_id') // Verificar si no ha sido procesada como una compra
            ->first();

        // Si el usuario no tiene órdenes (no tiene carrito), crear uno nuevo
        if (!$existingOrder) {
            // Crear la nueva orden en la tabla order_books
            $order = Order::create([
                'quantity' => 1, // Puedes manejar la cantidad según lo necesites
                'price' => $book->price,
                'book_fk' => $book->book_id,
                'buy_fk' => $user->user_id, // Asociar la orden con el usuario
            ]);

            // Crear la relación entre el pedido y el usuario en la tabla orders_has_users
            DB::table('orders_has_users')->insert([
                'order_book_fk' => $order->order_book_id,
                'user_fk' => $user->user_id,
            ]);
        } else {
            // Si ya existe una orden en el carrito, agregar el libro a la orden existente (si es necesario)
            // Aquí puedes modificar la lógica si deseas actualizar la cantidad o realizar otro comportamiento
            $order = Order::create([
                'quantity' => 1, // Puedes aumentar la cantidad si lo necesitas
                'price' => $book->price,
                'book_fk' => $book->book_id,
                'buy_fk' => $user->user_id, // Asociar la orden con el usuario
            ]);

            // Crear la relación entre el pedido y el usuario en la tabla orders_has_users
            DB::table('orders_has_users')->insert([
                'order_book_fk' => $order->order_book_id,
                'user_fk' => $user->user_id,
            ]);
        }

        // Redirigir al carrito o a la página de detalles con un mensaje de éxito
        return redirect()->route('cart.cart')->with('success', 'Book added to your cart successfully!');
    }
}
