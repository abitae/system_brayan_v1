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
        Schema::create('encomiendas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('transportista_id')->constrained('transportistas')->onDelete('cascade')->nullable();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade')->nullable();

            //remitente
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');

            //destinatario
            $table->unsignedBigInteger('customer_dest_id');
            $table->foreign('customer_dest_id')->references('id')->on('customers');
            $table->unsignedBigInteger('sucursal_dest_id');
            $table->foreign('sucursal_dest_id')->references('id')->on('sucursals');
            //facturacion
            $table->unsignedBigInteger('customer_fact_id');
            $table->foreign('customer_fact_id')->references('id')->on('customers');


            $table->decimal('cantidad', 8, 2);
            $table->decimal('monto', 8, 2);

            //descuento
            $table->decimal('monto_descuento', 8, 2)->nullable();
            $table->string('motivo_descuento')->nullable();

            //documentos relacionados
            $table->unsignedInteger('doc_ticket')->nullable();
            $table->unsignedInteger('doc_guia')->nullable();
            $table->unsignedInteger('doc_factura')->nullable();
            //Fechas
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->dateTime('fecha_recepcion')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->dateTime('fecha_retorno')->nullable();

            $table->string('estado_pago');
            $table->string('tipo_pago')->default('Contado');
            $table->string('metodo_pago')->nullable();
            $table->string('tipo_comprobante');

            $table->string('estado_credito')->nullable();

            $table->json('docsTraslado')->nullable();

            $table->text('glosa')->nullable();
            $table->text('observation')->nullable();
            $table->string('estado_encomienda');
            $table->integer('pin')->unsigned();
            $table->boolean('isTransbordo')->default(false)->nullable();
            $table->boolean('isHome')->default(false);
            $table->boolean('isReturn')->default(false);
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('encomiendas');
    }
};
