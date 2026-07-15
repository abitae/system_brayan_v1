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
        Schema::create('subscription_notices', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_vencimiento')->nullable();
            $table->boolean('is_activo')->default(false);
            $table->boolean('is_close')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_notices');
    }
};
