<?php

namespace Database\Seeders;

use App\Models\Configuration\Transportista;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $transportistas = [
            [
                'type_code' => '1',
                'dni' => '43695077',
                'licencia' => 'R43695077',
                'name' => 'DENNIS NAVARRO MOYA',
                'tipo' => 'INTERNO',

            ],
            [
                'type_code' => '1',
                'dni' => '71432076',
                'licencia' => 'P71432076',
                'name' => 'DENIS PEREZ MENDOZA',
                'tipo' => 'INTERNO',

            ],
            [
                'type_code' => '1',
                'dni' => '21120418',
                'licencia' => 'Q21120418',
                'name' => 'GUMERCINDO LEONCIO VELAZQUE SAVALA',
                'tipo' => 'INTERNO',

            ],
            [
                'type_code' => '1',
                'dni' => '40871461',
                'licencia' => 'P40871461',
                'name' => 'HERNAN MARTINEZ CRISTOBAL',
                'tipo' => 'INTERNO',

            ],
            [
                'type_code' => '1',
                'dni' => '20119169',
                'licencia' => 'P20119169',
                'name' => 'HENRY PERCY SANABRIA ÑAHUINCOPA',
                'tipo' => 'INTERNO',
                
            ],
        ];
        foreach ($transportistas as $transportista) {
            Transportista::create($transportista);
        }
    }
}
