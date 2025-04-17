<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';

    protected $fillable = ['user_id', 'cost', 'food_id'];

    public function players()
    {
        return $this->belongsToMany(player::class, 'partida_player_pedido')
            ->withPivot('partida_id')
            ->withTimestamps();
    }

    public function partidas()
    {
        return $this->belongsToMany(partida::class, 'partida_player_pedido')
            ->withPivot('player_id')
            ->withTimestamps();
    }

    public function comida()
    {
        return $this->belongsTo(food::class, 'food_id');
    }

    public function descuentos()
    {
        return $this->belongsToMany(descuento::class, 'descuento')
            ->withPivot('descuento_id')
            ->withTimestamps();
    }

}
