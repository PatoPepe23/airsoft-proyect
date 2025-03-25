<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedidocomida extends Model
{
    use HasFactory;

    protected $table = 'pedido_comida';

    protected $fillable = ['pedido_id', 'food_id'];
}
