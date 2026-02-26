<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order_books';

    protected $primaryKey = 'order_book_id';

    protected $fillable = ['quantity', 'price', 'book_fk', 'buy_fk'];

    // Relación con el modelo Book
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_fk');
    }

    // Relación con el modelo Buy
    public function buy()
    {
        return $this->belongsTo(Buy::class, 'buy_fk');
    }
}
