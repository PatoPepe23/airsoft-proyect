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
    ];

    protected $fillable = ['DNI','nombrecompleto', 'telefono', 'email', 'team', 'alquiler', 'dentro'];

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_player_pedido')
            ->withPivot('pedido_id')
            ->withTimestamps();
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'partida_player_pedido')
            ->withPivot('partida_id')
            ->withTimestamps();
    }

}
