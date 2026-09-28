<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['invoice_details', 'ticket_details', 'despatche_details', 'note_details'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::getConnection()->getDriverName() === 'sqlite') {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->decimal('mtoValorUnitario', 12, 4)->nullable(false)->change();
                });

                continue;
            }

            DB::statement("ALTER TABLE `{$table}` MODIFY `mtoValorUnitario` DECIMAL(12,4) NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::getConnection()->getDriverName() === 'sqlite') {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->decimal('mtoValorUnitario', 8, 2)->nullable(false)->change();
                });

                continue;
            }

            DB::statement("ALTER TABLE `{$table}` MODIFY `mtoValorUnitario` DECIMAL(8,2) NOT NULL");
        }
    }
};
