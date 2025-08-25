<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partida extends Model
{
    use HasFactory;

    protected $table = 'partida';

    protected $fillable = ['fecha', 'plazas', 'tipo', 'cancelled', 'shift'];


    public function players()
    {
        return $this->belongsToMany(Player::class, 'partida_player_pedido')
            ->withPivot('entrada', 'pedido_id')
            ->withTimestamps();
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'partida_player_pedido')
            ->withPivot('entrada', 'player_id')
            ->withTimestamps();
    }
}
