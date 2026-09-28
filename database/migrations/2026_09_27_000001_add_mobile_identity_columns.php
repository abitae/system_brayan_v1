<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sucursal_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('sucursal_id')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('sucursal_id')->references('id')->on('sucursals')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->unique()->constrained('customers')->nullOnDelete();
            $table->foreignId('transportista_id')->nullable()->unique()->constrained('transportistas')->nullOnDelete();
        });

        Schema::table('encomiendas', function (Blueprint $table) {
            $table->foreignId('repartidor_user_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
        });

        Role::findOrCreate('Cliente', 'web');
        Role::findOrCreate('Repartidor', 'web');
    }

    public function down(): void
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('repartidor_user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
            $table->dropConstrainedForeignId('transportista_id');
            $table->dropForeign(['sucursal_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('sucursal_id')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('sucursal_id')->references('id')->on('sucursals')->cascadeOnDelete();
        });
    }
};
