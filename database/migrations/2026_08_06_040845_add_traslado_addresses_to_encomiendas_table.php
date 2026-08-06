<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            $table->string('partida_direccion')->nullable()->after('sucursal_dest_id');
            $table->string('partida_ubigeo')->nullable()->after('partida_direccion');
            $table->string('llegada_direccion')->nullable()->after('partida_ubigeo');
            $table->string('llegada_ubigeo')->nullable()->after('llegada_direccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            $table->dropColumn([
                'partida_direccion',
                'partida_ubigeo',
                'llegada_direccion',
                'llegada_ubigeo',
            ]);
        });
    }
};
