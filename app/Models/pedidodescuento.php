<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedidodescuento extends Model
{
    use HasFactory;

    protected $table = 'pedido_descuento';

    protected $fillable = ['pedido_id', 'descuento_id'];
}
