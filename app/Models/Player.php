<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'player';

    protected $casts = [
        'dentro' => 'boolean',
        'alquiler' => 'boolean',
    ];

    protected $fillable = ['DNI','nombrecompleto', 'telefono', 'email', 'team', 'alquiler', 'dentro'];

    public function partidas()
    {
        return $this->belongsToMany(partida::class, 'partida_player_pedido')
            ->withPivot('entrada','pedido_id')
            ->withTimestamps();
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'partida_player_pedido')
            ->withPivot('partida_id')
            ->withTimestamps();
    }

}
