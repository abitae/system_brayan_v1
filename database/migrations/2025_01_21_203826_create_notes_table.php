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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('sucursal_id')->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->string('ublVersion');
            $table->string('tipoDoc')->nullable(false);
            $table->string('serie')->nullable(false);
            $table->string('correlativo')->nullable(false);
            $table->date('fechaEmision')->nullable(false);
            $table->string('tipoDocAfectado');
            $table->string('numDocfectado');
            $table->string('codMotivo');
            $table->text('desMotivo');
            $table->string('tipoMoneda');
            $table->decimal('mtoOperGravadas',8,2);
            $table->decimal('mtoIGV',8,2);
            $table->decimal('totalImpuestos',8,2);
            $table->decimal('mtoImpVenta',8,2);
            $table->string('monto_letras');
            $table->json('legends')->nullable();
            $table->string('xml_path')->nullable();
            $table->string('xml_hash')->nullable();
            $table->string('cdr_description')->nullable();
            $table->string('cdr_code')->nullable();
            $table->text('cdr_note')->nullable();
            $table->string('cdr_path')->nullable();
            $table->string('errorCode')->nullable();
            $table->text('errorMessage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
