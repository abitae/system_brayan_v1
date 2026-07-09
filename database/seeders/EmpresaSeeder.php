<?php

namespace Database\Seeders;

use App\Models\Configuration\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->create([
            'ruc'             => '20568031734',
            'razonSocial'     => 'CORPORACIÓN LOGÍSTICO BRAYAN BRUHS EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA',
            'nombreComercial' => 'CORPORACIÓN LOGÍSTICO BRAYAN BRUHS EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA',
            'address'         => 'PJ. LOS PEDREGALES MZA. D LOTE. 4 GRU.SECTOR 3 LOS PEDREGAL   JUNíN -  HUANCAYO  -  EL TAMBO',
            'email'           => 'abel.arana@gmail.com',
            'telephone'       => '947199138',
            'logo_path'       => '/img/logo.png',
            'ctaBanco'        => '0004-3342343243',
            'pin'             => '123',
            'sol_user'        => 'ABELARAN',
            'sol_pass'        => 'Aarana25',
            'cert_path'       => './certificado_prueba.pem',
            'client_id'       => '3e259ea4-020b-4d40-9d22-94a2849c2e97',
            'client_secret'   => 'sDDp9G8LArGbKy2R0n9VYQ==',
            'production'      => false,
            'nroMtc'          => '1553682CNG',
        ]);
    }
}
