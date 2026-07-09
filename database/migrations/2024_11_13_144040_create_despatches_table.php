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
        Schema::create('despatches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encomienda_id')->constrained('encomiendas');
            $table->string('tipoDoc');
            $table->string('serie');
            $table->string('correlativo');
            $table->string('fechaEmision');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('flete_id')->constrained('customers');
            $table->foreignId('remitente_id')->constrained('customers');
            $table->foreignId('destinatario_id')->constrained('customers');
            $table->string('codTraslado');
            $table->string('modTraslado');


            $table->json('docsTraslado')->nullable();

            $table->string('fecTraslado')->nullable();
            $table->string('pesoTotal')->nullable();
            $table->string('undPesoTotal')->nullable();
            $table->string('llegada_ubigueo')->nullable();
            $table->string('llegada_direccion')->nullable();
            $table->string('partida_ubigueo')->nullable();
            $table->string('partida_direccion')->nullable();
            $table->string('chofer_tipoDoc')->nullable();
            $table->string('chofer_nroDoc')->nullable();
            $table->string('chofer_licencia')->nullable();
            $table->string('chofer_nombres')->nullable();
            $table->string('chofer_apellidos')->nullable();
            $table->string('vehiculo_placa')->nullable();
            $table->string('xml_path')->nullable();
            $table->string('xml_hash')->nullable();
            $table->string('cdr_description')->nullable();
            $table->string('cdr_code')->nullable();
            $table->string('cdr_note')->nullable();
            $table->string('cdr_path')->nullable();
            $table->decimal('mtoIGV', 8, 2)->nullable();
            $table->decimal('valorVenta', 8, 2)->nullable();
            $table->decimal('mtoImpVenta', 8, 2)->nullable();
            $table->string('monto_letras');//monto en letras
            $table->decimal('setPercent', 8, 2)->nullable();//porcentaje detraccion
            $table->decimal('setMount', 8, 2)->nullable();//monto detraccion
            $table->string('errorCode')->nullable();
            $table->string('errorMessage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despatches');
    }
};
