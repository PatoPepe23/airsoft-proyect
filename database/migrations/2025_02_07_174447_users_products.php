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
        Schema::create('users_products', function (Blueprint $table) {
            $table->foreign('id_products')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('received?');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
