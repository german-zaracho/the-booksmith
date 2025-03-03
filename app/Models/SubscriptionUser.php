<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;

    protected $table = 'subscriptions_has_users';
    //descomenta la linea de abajo si no se guarda bien la fecha de la subscription
    // public $timestamps = false;

    protected $fillable = ['subscription_fk', 'user_fk'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_fk');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_fk');
    }
}
