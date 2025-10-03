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
        Schema::create('partida', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('plazas');
            $table->integer('alquiler');
            $table->string('tipo');
            $table->boolean('cancelled');
            $table->boolean('shift');
            $table->timestamps();

            $table->unique(['fecha', 'shift']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partida');
    }
};
