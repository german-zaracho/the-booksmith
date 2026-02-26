<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $primaryKey = 'status_id';

    protected $fillable = ['name'];

    // Relación con Buy (una categoría de estado puede estar asociada a múltiples compras)
    public function buys()
    {
        return $this->hasMany(Buy::class, 'status_fk');
    }
}
