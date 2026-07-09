<?php

namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursales = [
            ['code' => 'H28', 'name' => 'HUANCAYO 28 DE JULIO', 'address' => 'JR 28 DE JULIO 439 HUANCAYO'],
            ['code' => 'LVI', 'name' => 'LIMA VILLEGAS', 'address' => 'CALLE JULIO VILLEGAS 122-124 LA VICTORIA LIMA'],
            ['code' => 'LOB', 'name' => 'LIMA OBREROS', 'address' => 'JR OBREROS 125  A LA VICTORIA LIMA'],
            ['code' => 'HVU', 'name' => 'HUANCAVELICA UNIVERSITARIA', 'address' => 'Av. Universitaria 1003 Huancavelica'],
            ['code' => 'JAU', 'name' => 'JAUJA', 'address' => 'JAUJA'],
            ['code' => 'ORO', 'name' => 'OROYA', 'address' => 'Av. ALVERTO DIAS 1288- SANTA ROSA DE SACO OROYA'],
            ['code' => 'HUA', 'name' => 'HUANUCO', 'address' => 'HUANUCO'],
            ['code' => 'PIC', 'name' => 'PICHANAKI', 'address' => 'PICHANAKI'],
            ['code' => 'ARQ', 'name' => 'AREQUIPA', 'address' => 'AREQUIPA'],
            ['code' => 'TRU', 'name' => 'TRUJILLO', 'address' => 'TRUJILLO'],
        ];

        foreach ($sucursales as $sucursal) {
            Sucursal::factory()->create(array_merge($sucursal, [
                'codeSunat' => '0000',
                'igv' => 18,
                'serieFactura' => 'F001',
                'serieBoleta' => 'B001',
                'serieGuiaRemision' => 'V001',
                'serieNotaCreditoFactura' => 'FC01',
                'serieNotaCreditoBoleta' => 'BC01',
                'serieNotaDebitoFactura' => 'FD01',
                'serieNotaDebitoBoleta' => 'BD01',
                'color' => '#8fe6d4',
                'phone'    => '947199138',
                'email'    => $sucursal['code'].'@hotmail.com',
                'isActive' => true,
            ]));
        }
    }
}
