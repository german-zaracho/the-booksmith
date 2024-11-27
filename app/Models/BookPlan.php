<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPlan extends Model
{
    use HasFactory;

    protected $table = 'book_plans';

    protected $primaryKey = 'book_plan_id';

    protected $fillable = [
        'total_price',
        'name',
        'description', 
        'month',
    ];

    // Relacion con las suscripciones
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'book_plan_fk');
    }
}
