<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partida_player_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->references('id')->on('player');
            $table->foreignId('partida_id');
            $table->boolean('shift')->default(false);
            $table->foreignId('pedido_id')->references('id')->on('pedido');
            $table->timestamps();

            $table->foreign(['partida_id', 'shift'])->references(['id', 'shift'])->on('partida')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partida_player_pedido');
    }
};
