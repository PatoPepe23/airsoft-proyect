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
        Schema::create('pedido-descuento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->references('id')->on('pedido');
            $table->foreignId('descuento_id')->references('id')->on('descuento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido-descuento');
    }
};
