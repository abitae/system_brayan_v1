<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('baja_ticket')->nullable();
            $table->string('baja_cdr_path')->nullable();
            $table->string('baja_motivo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['baja_ticket', 'baja_cdr_path', 'baja_motivo']);
        });
    }
};
