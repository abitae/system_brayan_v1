<?php

namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sucursal::factory()->create([
            'code' => 'REX',
            'name' => 'LA RANA EXPRESS',
            'address' => 'Perú',
            'codeSunat' => '0000',
            'igv' => 18,
            'serieFactura' => 'F001',
            'serieBoleta' => 'B001',
            'serieGuiaRemision' => 'V001',
            'serieNotaCreditoFactura' => 'FC01',
            'serieNotaCreditoBoleta' => 'BC01',
            'serieNotaDebitoFactura' => 'FD01',
            'serieNotaDebitoBoleta' => 'BD01',
            'color' => '#7CB518',
            'phone' => '976790973',
            'email' => 'rex@ranaexpress.pe',
            'isActive' => true,
        ]);
    }
}
