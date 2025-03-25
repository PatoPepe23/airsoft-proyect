<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partidaplayerpedido extends Model
{
    use HasFactory;

    protected $table = 'partida_player_pedido';

    protected $fillable = ['player_id', 'partida_id', 'pedido_id'];
}
