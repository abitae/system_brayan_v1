<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('permisos:agregar-report-ventas', function () {
    $permission = Permission::firstOrCreate([
        'name' => 'report.ventas',
        'guard_name' => 'web',
    ]);

    collect(['SuperAdmin', 'Administrador', 'Admin sucursal'])
        ->each(function (string $roleName) use ($permission) {
            $role = Role::where('name', $roleName)
                ->where('guard_name', 'web')
                ->first();

            if (! $role) {
                $this->warn("Rol no encontrado: {$roleName}");

                return;
            }

            if (! $role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }

            $this->info("Permiso report.ventas asignado a {$roleName}");
        });

    app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    $this->info('Permiso report.ventas listo.');
})->purpose('Crea el permiso report.ventas y lo asigna a los roles principales');
