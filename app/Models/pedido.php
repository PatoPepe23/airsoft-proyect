<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';

    protected $fillable = ['user_id', 'partida_id', 'food_id'];
}
