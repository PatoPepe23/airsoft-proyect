<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;

class ReservaTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_preciocomidatrue(): void
    {
        $request = (object)[
            'precio' => 6,
            'food' => true,
            'food_id' => 2,
        ];

        // Mock de la relación comida (comida()->attach(...))
        $comidaMock = Mockery::mock();
        $comidaMock->shouldReceive('attach')->once()->with($request->food_id);

        // Mock del modelo Pedido
        $pedidoMock = Mockery::mock('pedido');
        $pedidoMock->shouldReceive('comida')->andReturn($comidaMock);

        // Simulamos lógica de negocio
        $pedidoMock->cost = $request->precio;

        if ($request->food) {
            $pedidoMock->comida()->attach($request->food_id);
        }

        // Validamos que el precio fue asignado correctamente
        $this->assertEquals(6, $pedidoMock->cost);
    }

    public function test_preciocomidafalse(): void
    {

        $request = (object)[
            'precio' => 12,
            'food' => true,
            'food_id' => 2,
        ];

        // Mock de la relación comida (comida()->attach(...))
        $comidaMock = Mockery::mock();
        $comidaMock->shouldReceive('attach')->once()->with($request->food_id);

        // Mock del modelo Pedido
        $pedidoMock = Mockery::mock('pedido');
        $pedidoMock->shouldReceive('comida')->andReturn($comidaMock);

        // Simulamos lógica de negocio
        $pedidoMock->cost = $request->precio;

        if ($request->food) {
            $pedidoMock->comida()->attach($request->food_id);
        }

        // Validamos que el precio fue asignado correctamente
        $this->assertEquals(6, $pedidoMock->cost);

    }
}
