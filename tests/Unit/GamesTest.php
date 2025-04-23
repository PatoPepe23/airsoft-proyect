<?php

namespace Tests\Unit;

use App\Models\partida;
use PHPUnit\Framework\TestCase;

class GamesTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function update_game_test(): void
    {

        $data = [
            'id' => 1,
        ];

        $game = partida::update('cancelled', true)->where("id", "=", $data->id);

        $this->assertTrue($game);
    }
}
