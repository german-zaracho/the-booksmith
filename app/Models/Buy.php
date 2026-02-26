<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $table = 'buys';

    protected $primaryKey = 'buy_id';

    protected $fillable = ['total_price', 'date', 'status_fk'];

    // Relación con el modelo Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_fk');
    }

    // Relación con el modelo Cart (order_books)
    public function cart()
    {
        return $this->hasMany(Order::class, 'buy_fk');
    }
}
