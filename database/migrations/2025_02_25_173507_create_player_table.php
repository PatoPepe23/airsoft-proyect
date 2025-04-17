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
        Schema::create('player', function (Blueprint $table) {
            $table->id();
            $table->string('DNI');
            $table->string('nombrecompleto');
            $table->string('email');
            $table->integer('telefono')->nullable();
            $table->string('team')->nullable();
            $table->boolean('alquiler');
            $table->boolean('dentro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player');
    }
};
