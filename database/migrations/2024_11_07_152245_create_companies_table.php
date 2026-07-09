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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('ruc')->unique();
            $table->string('razonSocial');
            $table->string('nombreComercial');
            $table->string('address');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('ubigeo')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('ctaBanco')->nullable();
            $table->string('pin')->nullable();
            $table->string('nroMtc')->nullable();
            //Credenciales SOL
            $table->string('sol_user');
            $table->string('sol_pass');
            $table->string('cert_path');
            //Credenciales API
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->boolean('production')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
