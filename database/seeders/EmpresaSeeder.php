<?php

namespace Database\Seeders;

use App\Models\Configuration\Company;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->create([
            'ruc'             => '20603506147',
            'razonSocial'     => 'LA RANA EXPRESS E.I.R.L.',
            'nombreComercial' => 'LA RANA EXPRESS E.I.R.L.',
            'address'         => 'Perú',
            'email'           => 'contacto@ranaexpress.pe',
            'telephone'       => '976790973',
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
