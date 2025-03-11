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
        Schema::create('partida-player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->references('id')->on('player');
            $table->foreignId('partida_id')->references('id')->on('partida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partida-player');
    }
};
