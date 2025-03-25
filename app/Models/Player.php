<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'player';

    protected $fillable = ['DNI','nombrecompleto', 'telefono', 'email', 'team', 'alquiler'];
}
