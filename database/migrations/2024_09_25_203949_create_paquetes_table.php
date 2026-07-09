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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encomienda_id')->constrained('encomiendas')->onDelete('cascade');
            $table->decimal('cantidad', 8, 2);
            $table->string('und_medida');
            $table->string('description');
            $table->string('peso');
            $table->decimal('amount', 8, 2);
            $table->decimal('sub_total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
