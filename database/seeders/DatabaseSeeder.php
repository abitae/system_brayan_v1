<?php
namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                // Otros seeders
            SqlFileSeeder::class,
            EmpresaSeeder::class,
            SucursalSeeder::class,
            PermisoSeeder::class,
            TransportistaSeeder::class,
            VehiculoSeeder::class,
            SubscriptionNoticeSeeder::class,
        ]);
        //Customer::factory(10)->create();

        /* foreach (Sucursal::all() as $sucursal) {
            $encomiendas = Encomienda::factory(10)->create([
                'sucursal_id' => 2,
                'sucursal_dest_id' => 1,
                'pin' => '123',
                'isHome' =>true,
                'isReturn' =>false,
            ]);

            // Create one package for each shipping order
            foreach ($encomiendas as $encomienda) {
                Paquete::factory()->create([
                    'encomienda_id' => $encomienda->id,

                ]);
            }
        } */
    }
}
