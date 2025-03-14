<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partida extends Model
{
    use HasFactory;

    protected $table = 'partida';

    protected $fillable = ['fecha', 'plazas', 'tipo', 'cancelled'];

    protected static function boot(){
        parent::boot();

        static::deleting(function ($partida){
            $fechaConvertida = Carbon::createFromFormat('d-m-Y', $partida->fecha);

            $nuevaFecha = $fechaConvertida->addDays(56);

            Partida::create([
                'fecha' => $nuevaFecha->format('d-m-Y'),
                'plazas' => 220,
                'tipo' => 'dominguera',
                'cancelled' => false
            ]);
        });
    }
}
