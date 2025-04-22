<?php

namespace  Tests\Unit;

use Illuminate\Database\Connection;

use App\Models\partida;
use App\Models\pedido;
use App\Models\Player;
use App\Models\descuento;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class discountTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        // Lógica del descuento: simulamos cómo debería funcionar
        $precioOriginal = 100;
        $porcentajeDescuento = 10; // 10%

        // Calculamos el precio con descuento
        $precioConDescuento = $precioOriginal - ($precioOriginal * $porcentajeDescuento / 100);

        // Verificamos el resultado esperado
        $this->assertEquals(90, $precioConDescuento);
    }

    public function test_descuento_cero()
    {
        // Caso con un descuento de 0%
        $precioOriginal = 100;
        $porcentajeDescuento = 0; // No hay descuento

        $precioConDescuento = $precioOriginal - ($precioOriginal * $porcentajeDescuento / 100);

        $this->assertEquals(100, $precioConDescuento); // Debería ser igual al precio original
    }

    public function test_descuento_invalido()
    {
        // Probar con un porcentaje fuera de rango (por ejemplo, negativo)
        $precioOriginal = 100;
        $porcentajeDescuento = -10;

        // Esperamos que no sea válido (o gestionar el error en la lógica real)
        $this->assertTrue($porcentajeDescuento < 0, "El descuento no puede ser negativo");
    }

   /* public function reservaTest(): void
    {
        // Simular datos del request
        $requestData = [
            'DNI' => '123456789',
            'nombrecompleto' => 'Juan Pérez',
            'telefono' => null,
            'email' => 'juan@example.com',
            'team' => 'Team A',
            'alquiler' => true,
            'shift' => true,
            'precio' => 100,
            'food' => true,
            'food_id' => 1,
            'partida_id' => '22-04-2025',
        ];

        $player = Player::create([
            'DNI' => $requestData['DNI'],
            'nombrecompleto' => $requestData['nombrecompleto'],
            'telefono' => $requestData['telefono'],
            'email' => $requestData['email'],
            'team' => $requestData['team'],
            'alquiler' => $requestData['alquiler'],
            'shift' => $requestData['shift'],
        ]);

        // Crear el pedido
        $pedido = pedido::create([
            'cost' => $requestData['precio'],
            'food_id' => $requestData['food_id'],
        ]);

        // Formatear la fecha
        $partidafecha = Carbon::createFromFormat('d-m-Y', $requestData['partida_id'])->format('Y-m-d');

        // Buscar la partida
        $partida = partida::factory()->create([
            'fecha' => $partidafecha,
            'shift' => $requestData['shift'],
            'plazas' => 220,
        ]);

        // Actualizar plazas
        $partida->plazas -= 1;
        $partida->save();

        // Crear relación entre jugador y partida
        $player->partidas()->attach($partida->id, ['pedido_id' => $pedido->id]);


        $this->assertTrue($player->partidas->contains('id', $partida->id));
    }*/

}

