<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partidaplayer extends Model
{
    use HasFactory;

    protected $table = 'partida-player';

    protected $fillable = ['player_id', 'partida_id'];
}
