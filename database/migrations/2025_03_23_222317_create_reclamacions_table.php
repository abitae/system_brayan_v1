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
        Schema::create('reclamacions', function (Blueprint $table) {
            $table->id();
            $table->string('reclamo_nombre');
            $table->string('reclamo_documento');
            $table->string('reclamo_telefono');
            $table->string('reclamo_email');
            $table->string('reclamo_direccion');
            $table->string('reclamo_tipo');
            $table->string('reclamo_producto');
            $table->string('reclamo_monto');
            $table->string('reclamo_descripcion');
            $table->string('reclamo_politicas');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamacions');
    }
};
