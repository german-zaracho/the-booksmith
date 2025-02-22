<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'img'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //added just now, delete if this does not work
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function subscription()
    {
        return $this->hasOneThrough(
            Subscription::class,
            SubscriptionUser::class,
            'user_fk',         // Foreign key en subscriptions_has_users
            'subscription_id', // Foreign key en subscriptions
            'user_id',         // Local key en users
            'subscription_fk'  // Local key en subscriptions_has_users
        )->where('is_active', true); // Solo la suscripción activa
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'subscriptions_has_users', 'user_fk', 'subscription_fk');
    }
}
