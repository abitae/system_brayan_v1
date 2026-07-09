<?php

namespace Database\Seeders;

use App\Models\Configuration\Vehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = [
            [
                'name' => 'V7H919',
                'marca' => 'HINO',
                'modelo' => 'HINO',
                'tipo' => 'C-3',
                'color' => 'ROJO',
                'largo' => '10',
                'ancho' => '2',
                'alto' => '2',
                'pesoBruto' => '10000',
                'pesoNeto' => '8000',
                'mtc' => '152010570',
            ],
            [
                'name' => 'W6J769',
                'marca' => 'IZUSO',
                'modelo' => 'IZUSO',
                'tipo' => 'C-3',
                'color' => 'ROJO',
                'largo' => '10',
                'ancho' => '2',
                'alto' => '2',
                'pesoBruto' => '10000',
                'pesoNeto' => '8000',
                'mtc' => '152000972',
            ],
            [
                'name' => 'W7L874',
                'marca' => 'HINO',
                'modelo' => 'HINO',
                'tipo' => 'N-3',
                'color' => 'ROJO',
                'largo' => '10',
                'ancho' => '2',
                'alto' => '2',
                'pesoBruto' => '10000',
                'pesoNeto' => '8000',
                'mtc' => '152000972',
            ],
        ];
        foreach ($vehiculos as $vehiculo) {
            Vehiculo::create($vehiculo);
        }
    }
}
