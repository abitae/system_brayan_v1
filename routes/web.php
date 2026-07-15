<?php

use App\Http\Controllers\pdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use App\Livewire\Caja\CajaLive;
use App\Livewire\Cobrar\EncomiendaCobrar;
use App\Livewire\Componentes;
use App\Livewire\Configuration\CompanyLive;
use App\Livewire\Configuration\RoleLive;
use App\Livewire\Configuration\SucursalConfigurationLive;
use App\Livewire\Configuration\SucursalLive;
use App\Livewire\Configuration\TransportistaLive;
use App\Livewire\Configuration\UserLive;
use App\Livewire\Configuration\VehiculoLive;
use App\Livewire\Facturacion\DespatcheLive;
use App\Livewire\Facturacion\InvoiceCreateLive;
use App\Livewire\Facturacion\InvoiceLive;
use App\Livewire\Facturacion\NoteCreateLive;
use App\Livewire\Facturacion\NoteLive;
use App\Livewire\Facturacion\TicketLive;
use App\Livewire\Frontend\MessageLive;
use App\Livewire\Frontend\ReclamoLive;
use App\Livewire\Home\DashboardLive;
use App\Livewire\Home\TutorialesLive;
use App\Livewire\Package\CustomerLive;
use App\Livewire\Package\DeliverPackageLive;
use App\Livewire\Package\HomePackageLive;
use App\Livewire\Package\ManifiestoLive;
use App\Livewire\Package\ReceivePackageLive;
use App\Livewire\Package\RecordPackageLive;
use App\Livewire\Package\RegisterLive;
use App\Livewire\Package\ReturnPackageLive;
use App\Livewire\Package\SendPackageLive;
use App\Livewire\Report\ContableReport;
use App\Livewire\Report\EncomiendasReport;
use App\Livewire\Report\VentasReport;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('livewire.facturacion.create-invoice');
});
Route::get('/', function () {
    return redirect()->away('http://frontend_brayan.test');
})->name('index');
Route::get('/nosotros', [WebsiteController::class, 'abount'])->name('abount');
Route::get('/servicios', [WebsiteController::class, 'servicios'])->name('servicios');
Route::get('/terminos', [WebsiteController::class, 'terminos'])->name('politicas-privacidad');
Route::get('/rastrea', [WebsiteController::class, 'rastrea'])->name('rastrea');
Route::post('/tracking', [WebsiteController::class, 'trackingSearch'])->name('tracking.search');
Route::get('/contacto', [WebsiteController::class, 'contact'])->name('contact');
Route::post('/contacto', [WebsiteController::class, 'contactForm'])->name('contacto.enviar');
Route::get('/reclamaciones', [WebsiteController::class, 'reclamaciones'])->name('reclamos');
Route::post('/reclamaciones', [WebsiteController::class, 'reclamacionesForm'])->name('reclamaciones.enviar');
Route::get('/prohibiciones', [WebsiteController::class, 'prohibiciones'])->name('prohibiciones');
Route::get('/comunicate', [WebsiteController::class, 'comunicate'])->name('comunicate');
Route::get('/cotiza', [WebsiteController::class, 'cotiza'])->name('cotiza');
Route::get('/rastreo', [WebsiteController::class, 'rastreo'])->name('rastreo');
Route::get('/agencias', [WebsiteController::class, 'agencias'])->name('agencias');
Route::get('/tarifario', [WebsiteController::class, 'tarifario'])->name('tarifario');
Route::get('/terminales', [WebsiteController::class, 'terminales'])->name('terminales');
Route::get('/envia', [WebsiteController::class, 'envia'])->name('envia');
Route::get('/servicios/courier', [WebsiteController::class, 'courier'])->name('courier');
Route::get('/servicios/mudanza', [WebsiteController::class, 'mudanza'])->name('mudanza');
Route::get('/servicios/almacen', [WebsiteController::class, 'almacen'])->name('almacen');
Route::get('/servicios/door-to-door', [WebsiteController::class, 'doorToDoor'])->name('door-to-door');
Route::get('/servicios/recojo', [WebsiteController::class, 'recojo'])->name('recojo');
Route::get('/servicios/carga-consolidada', [WebsiteController::class, 'cargaConsolidada'])->name('carga-consolidada');
Route::get('/servicios/traslados-vehiculos', [WebsiteController::class, 'trasladoVehiculos'])->name('traslado-vehiculos');
Route::get('/servicios/traslados-contenedores', [WebsiteController::class, 'trasladoContenedores'])->name('traslado-contenedores');






// Rutas de Dashboard y Perfil
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardLive::class)->name('dashboard');
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::get('/componentes', Componentes::class)->name('componentes');
});
Route::middleware('auth')->group(function () {
    Route::get('/tutorial', TutorialesLive::class)->name('tutorial.video')->middleware('can:tutorial.video');
});
// Rutas de Configuración
Route::middleware('auth')->group(function () {
    Route::get('/caja', CajaLive::class)->name('caja.index')->middleware('can:caja.index');
    Route::get('/sucursal', SucursalLive::class)->name('config.sucursal')->middleware('can:config.sucursal');
    Route::get('/vehiculo', VehiculoLive::class)->name('config.vehiculo')->middleware('can:config.vehiculo');
    Route::get('/transportistas', TransportistaLive::class)->name('config.transportista')->middleware('can:config.transportista');
    Route::get('/usuarios', UserLive::class)->name('config.user')->middleware('can:config.user');
    Route::get('/role', RoleLive::class)->name('config.role')->middleware('can:config.role');
    Route::get('/empresa', CompanyLive::class)->name('config.company')->middleware('can:config.company');
    Route::get('/rutas', SucursalConfigurationLive::class)->name('config.configuration')->middleware('can:config.ruta');
});

// Rutas de Paquetes y Encomiendas
Route::middleware('auth')->group(function () {
    Route::get('/clientes', CustomerLive::class)->name('package.customer')->middleware('can:package.customer');
    Route::get('/registrar', RegisterLive::class)->name('package.register')->middleware('can:package.register');
    Route::get('/enviar', SendPackageLive::class)->name('package.send')->middleware('can:package.send');
    Route::get('/recibir', ReceivePackageLive::class)->name('package.receive')->middleware('can:package.receive');
    Route::get('/entregar', DeliverPackageLive::class)->name('package.deliver')->middleware('can:package.deliver');
    Route::get('/historial', RecordPackageLive::class)->name('package.record')->middleware('can:package.record');
    Route::get('/domicili', HomePackageLive::class)->name('package.home')->middleware('can:package.home');
    Route::get('/retorno', ReturnPackageLive::class)->name('package.return')->middleware('can:package.return');
    Route::get('/manifiesto', ManifiestoLive::class)->name('package.manifiesto')->middleware('can:package.manifiesto');
});

// Rutas de Frontend
Route::middleware('auth')->group(function () {
    Route::get('/message', MessageLive::class)->name('message.frontend')->middleware('can:message.frontend');
    Route::get('/reclamos', ReclamoLive::class)->name('reclamaciones.frontend')->middleware('can:reclamaciones.frontend');
});

// Rutas de Facturación
Route::middleware('auth')->group(function () {
    Route::get('/ticket', TicketLive::class)->name('facturacion.ticket')->middleware('can:facturacion.ticket');
    Route::get('/invoice', InvoiceLive::class)->name('facturacion.invoice')->middleware('can:facturacion.invoice');
    Route::get('/despache', DespatcheLive::class)->name('facturacion.despache')->middleware('can:facturacion.despache');
    Route::get('/note', NoteLive::class)->name('facturacion.note')->middleware('can:facturacion.note');
    Route::get('/facturacion/create-invoice/{id?}', InvoiceCreateLive::class)->name('facturacion.create-invoice')->middleware('can:facturacion.create-invoice');
    Route::get('/facturacion/create-note/{id?}', NoteCreateLive::class)->name('facturacion.create-note')->middleware('can:facturacion.create-note');
});

Route::middleware('auth')->group(function () {
    Route::get('/report/encomiendas', EncomiendasReport::class)->name('report.encomiendas')->middleware('can:report.encomienda');
    Route::get('/report/contable', ContableReport::class)->name('report.contable')->middleware('can:report.contable');
    Route::get('/report/ventas', VentasReport::class)->name('report.ventas')->middleware('can:report.ventas');
    Route::get('/cobrar/encomiendas', EncomiendaCobrar::class)->name('cobrar.encomiendas');
});

Route::get('/ticket/80mm/{ticket}', [pdfController::class, 'ticket80mm']);
Route::get('/ticket/a4/{ticket}', [pdfController::class, 'ticketA4']);
Route::get('/invoice/80mm/{invoice}', [pdfController::class, 'invoice80mm']);
Route::get('/invoice/a4/{invoice}', [pdfController::class, 'invoiceA4']);
Route::get('/despache/80mm/{despache}', [pdfController::class, 'despache80mm']);
Route::get('/despache/a4/{despache}', [pdfController::class, 'despacheA4']);
Route::get('/sticker/a5/{encomienda}', [pdfController::class, 'stickerA5']);
Route::get('/declaracion/{encomienda}', [pdfController::class, 'declaracion']);
Route::get('/note/80mm/{note}', [pdfController::class, 'note80mm']);
Route::get('/note/a4/{note}', [pdfController::class, 'noteA4']);
Route::get('/caja/80mm/{caja}', [pdfController::class, 'caja']);
require __DIR__ . '/auth.php';
