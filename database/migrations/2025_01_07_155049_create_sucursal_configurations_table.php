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
        Schema::create('sucursal_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained('sucursals')->onDelete('cascade');
            $table->foreignId('sucursal_destino_id')->constrained('sucursals')->onDelete('cascade');
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->foreignId('transportista_id')->constrained('transportistas')->onDelete('cascade');
            $table->date('date_config');
            $table->boolean('isActive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursal_configurations');
    }
};
