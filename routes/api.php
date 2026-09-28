<?php

use App\Http\Controllers\Api\Frontend\TrackingController;
use App\Http\Controllers\Api\V1\AdminSucursalController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\RepartidorController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:30,1')->group(function () {
    Route::get('/frontend/tracking', [TrackingController::class, 'show']);
});

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('cliente/registro', [AuthController::class, 'registerCliente'])->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

        Route::middleware('mobile.role:Cliente')->prefix('cliente')->group(function () {
            Route::get('encomiendas', [ClienteController::class, 'encomiendas']);
            Route::get('comprobantes', [ClienteController::class, 'comprobantes']);
            Route::get('comprobantes/{invoice}/pdf', [ClienteController::class, 'comprobantePdf'])->whereNumber('invoice');
            Route::get('cuentas-por-pagar', [ClienteController::class, 'cuentasPorPagar']);
            Route::get('cuentas-pagadas', [ClienteController::class, 'cuentasPagadas']);
        });

        Route::middleware('mobile.role:Repartidor')->prefix('repartidor')->group(function () {
            Route::get('caja', [RepartidorController::class, 'caja']);
            Route::post('caja', [RepartidorController::class, 'abrirCaja']);
            Route::post('caja/cerrar', [RepartidorController::class, 'cerrarCaja']);
            Route::get('encomiendas', [RepartidorController::class, 'encomiendas']);
            Route::get('encomiendas/{encomienda}', [RepartidorController::class, 'show'])->whereNumber('encomienda');
            Route::post('encomiendas/{encomienda}/entregar', [RepartidorController::class, 'entregar'])->whereNumber('encomienda');
        });

        Route::middleware('mobile.role:Admin sucursal')->prefix('admin')->group(function () {
            Route::get('entregas', [AdminSucursalController::class, 'entregas']);
            Route::get('repartidores', [AdminSucursalController::class, 'repartidores']);
            Route::post('entregas/{encomienda}/asignar', [AdminSucursalController::class, 'asignar'])->whereNumber('encomienda');
            Route::get('cajas', [AdminSucursalController::class, 'cajas']);
        });
    });
});
