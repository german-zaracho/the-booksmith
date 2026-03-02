<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table      = 'subscriptions';
    protected $primaryKey = 'subscription_id';

    protected $fillable = [
        'start_date',
        'end_date',
        'is_active',
        'book_plan_fk',
        'payment_method',  // 'mercadopago' | 'credit_card'
        'payment_status',  // 'completed' | 'pending'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'subscriptions_has_users', 'subscription_fk', 'user_fk');
    }

    public function bookPlan()
    {
        return $this->belongsTo(BookPlan::class, 'book_plan_fk');
    }
}
