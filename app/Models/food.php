<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class food extends Model
{
    use HasFactory;

    protected $table = 'food';

    protected $fillable = ['nombre'];

    public function pedido()
    {
        return $this->hasMany(Pedido::class);
    }
}
