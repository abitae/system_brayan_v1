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
        Schema::create('sucursals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('codeSunat')->default('0000');
            $table->decimal('igv', 8, 2)->default(18);
            $table->string('serieFactura');
            $table->string('serieBoleta');
            $table->string('serieGuiaRemision');
            $table->string('serieNotaCreditoFactura');
            $table->string('serieNotaCreditoBoleta');
            $table->string('serieNotaDebitoFactura');
            $table->string('serieNotaDebitoBoleta');
            $table->string('color')->nullable();
            $table->string('name');
            $table->string('departamento')->nullable();
            $table->string('provincia')->nullable();
            $table->string('distrito')->nullable();
            $table->string('urbanizacion')->nullable();
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('ubigeo')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursals');
    }
};
