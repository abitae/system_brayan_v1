<?php

namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $permissions = [
            'caja.index',
            'config.ruta',
            'menu.encomienda',
            'menu.entrega',
            'menu.facturacion',
            'menu.reporte',
            'menu.configuracion',
            'config.sucursal',
            'config.vehiculo',
            'config.transportista',
            'config.user',
            'config.role',
            'config.company',
            'report.encomienda',
            'report.contable',
            'report.ventas',
            'package.customer',
            'package.register',
            'package.send',
            'package.receive',
            'package.deliver',
            'package.record',
            'package.home',
            'package.return',
            'package.manifiesto',
            'message.frontend',
            'reclamaciones.frontend',
            'facturacion.ticket',
            'facturacion.invoice',
            'facturacion.despache',
            'facturacion.note',
            'facturacion.create-invoice',
            'facturacion.create-note',
            'tutorial.video'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name' => 'Abel Arana',
            'email' => 'abel.arana@hotmail.com',
            'sucursal_id' => 1,
            'isActive' => true,
            'password' => bcrypt('lobomalo123'),
        ])->assignRole('SuperAdmin');

        $role = Role::create(['name' => 'Administrador', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'administrador@brayanbruhs.pe',
            'sucursal_id' => 1,
            'isActive' => true,
            'password' => bcrypt('password'),
        ])->assignRole('Administrador');

        $role = Role::create(['name' => 'Admin sucursal', 'guard_name' => 'web']);
        $role->syncPermissions([
            'caja.index',
            'config.ruta',
            'menu.encomienda',
            'menu.entrega',
            'menu.facturacion',
            'menu.reporte',
            //'menu.configuracion',
            //'config.sucursal',
            //'config.vehiculo',
            //'config.transportista',
            //'config.user',
            //'config.role',
            //'config.company',
            'report.encomienda',
            'report.contable',
            'report.ventas',
            'package.customer',
            'package.register',
            'package.send',
            'package.receive',
            'package.deliver',
            'package.record',
            'package.home',
            'package.return',
            'package.manifiesto',
            'message.frontend',
            'reclamaciones.frontend',
            'facturacion.ticket',
            'facturacion.invoice',
            'facturacion.despache',
            'facturacion.note',
            'facturacion.create-invoice',
            'facturacion.create-note',
            'tutorial.video'
        ]);

        // Create admin users for each branch office
        $sucursales = Sucursal::all();
        foreach ($sucursales as $sucursal) {
            User::factory()->create([
                'name' => 'Administrador ' . $sucursal->code,
                'email' => 'admin.' . strtolower($sucursal->code) . '@brayanbruhs.pe',
                'sucursal_id' => $sucursal->id,
                'isActive' => true,
                'password' => bcrypt('password'),
            ])->assignRole('Admin sucursal');
        }
    }
}
