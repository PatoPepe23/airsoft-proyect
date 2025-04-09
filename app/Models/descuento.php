<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class descuento extends Model
{
    use HasFactory;

    protected $table = 'descuento';

    protected $fillable = ['codigo', 'porcentaje'];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido')
            ->withPivot('player_id')
            ->withTimestamps();
    }
}
