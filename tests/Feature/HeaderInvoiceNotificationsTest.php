<?php

namespace Tests\Feature;

use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Facturacion\Invoice;
use App\Models\Frontend\Message;
use App\Models\Frontend\Reclamacion;
use App\Models\Package\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class HeaderInvoiceNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (! extension_loaded('pdo_sqlite') && ! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('No PDO database driver available');
        }
    }

    public function test_header_muestra_boletas_y_facturas_pendientes_y_con_error(): void
    {
        Permission::create(['name' => 'facturacion.invoice', 'guard_name' => 'web']);

        $company = $this->createCompany();
        $sucursal = $this->createSucursal();
        $client = $this->createCustomer();
        $user = User::factory()->create(['sucursal_id' => $sucursal->id]);
        $user->givePermissionTo('facturacion.invoice');

        $this->createInvoice($company, $sucursal, $client, [
            'tipoDoc' => '01',
            'serie' => 'F001',
            'correlativo' => '1',
            'cdr_code' => null,
            'errorCode' => null,
        ]);
        $this->createInvoice($company, $sucursal, $client, [
            'tipoDoc' => '03',
            'serie' => 'B001',
            'correlativo' => '2',
            'cdr_code' => null,
            'errorCode' => 'SUNAT-ERR',
        ]);
        $this->createInvoice($company, $sucursal, $client, [
            'tipoDoc' => '01',
            'serie' => 'F001',
            'correlativo' => '3',
            'cdr_code' => '0',
            'errorCode' => null,
        ]);
        $this->createInvoice($company, $sucursal, $client, [
            'tipoDoc' => '03',
            'serie' => 'B001',
            'correlativo' => '4',
            'cdr_code' => null,
            'errorCode' => 'ANULADO-ERR',
            'estado' => 'ANULADO',
        ]);
        $this->createInvoice($company, $sucursal, $client, [
            'tipoDoc' => '07',
            'serie' => 'FC01',
            'correlativo' => '5',
            'cdr_code' => null,
            'errorCode' => null,
        ]);

        Message::create([
            'name' => 'Mensaje Test',
            'email' => 'mensaje@test.pe',
            'phone' => '999999999',
            'select' => 'Consulta',
            'message' => 'Mensaje activo',
            'isActive' => true,
        ]);
        Reclamacion::create([
            'reclamo_nombre' => 'Reclamo Test',
            'reclamo_documento' => '12345678',
            'reclamo_telefono' => '999999999',
            'reclamo_email' => 'reclamo@test.pe',
            'reclamo_direccion' => 'Av. Test',
            'reclamo_tipo' => 'reclamo',
            'reclamo_producto' => 'Servicio',
            'reclamo_monto' => '10',
            'reclamo_descripcion' => 'Descripcion',
            'reclamo_politicas' => 'on',
            'isActive' => true,
        ]);

        $this->actingAs($user)
            ->view('components.partials.header')
            ->assertSee('Pendientes de envío (1)', false)
            ->assertSee('Con error (1)', false)
            ->assertSee('2')
            ->assertDontSee('Mensajes')
            ->assertDontSee('Reclamaciones');
    }

    private function createCompany(): Company
    {
        return Company::forceCreate([
            'ruc' => '20123456789',
            'razonSocial' => 'EMPRESA TEST SAC',
            'nombreComercial' => 'EMPRESA TEST',
            'address' => 'Av. Test 123',
            'email' => 'test@empresa.pe',
            'telephone' => '999999999',
            'ubigeo' => '150101',
            'sol_user' => 'MODDATOS',
            'sol_pass' => 'MODDATOS',
            'cert_path' => 'certs/test.pem',
            'production' => false,
        ]);
    }

    private function createSucursal(): Sucursal
    {
        return Sucursal::create([
            'code' => 'SUC01',
            'codeSunat' => '0000',
            'igv' => 18,
            'serieFactura' => 'F001',
            'serieBoleta' => 'B001',
            'serieGuiaRemision' => 'T001',
            'serieNotaCreditoFactura' => 'FC01',
            'serieNotaCreditoBoleta' => 'BC01',
            'serieNotaDebitoFactura' => 'FD01',
            'serieNotaDebitoBoleta' => 'BD01',
            'name' => 'Sucursal Test',
            'address' => 'Av. Test 456',
            'isActive' => true,
        ]);
    }

    private function createCustomer(): Customer
    {
        return Customer::create([
            'type_code' => '6',
            'code' => '20123456789',
            'name' => 'CLIENTE TEST',
            'isActive' => true,
        ]);
    }

    private function createInvoice(Company $company, Sucursal $sucursal, Customer $client, array $overrides = []): Invoice
    {
        return Invoice::create(array_merge([
            'company_id' => $company->id,
            'sucursal_id' => $sucursal->id,
            'client_id' => $client->id,
            'tipoDoc' => '01',
            'tipoOperacion' => '0101',
            'serie' => 'F001',
            'correlativo' => '1',
            'fechaEmision' => '2024-07-10 09:00:00',
            'formaPago_moneda' => 'PEN',
            'formaPago_tipo' => 'Contado',
            'tipoMoneda' => 'PEN',
            'mtoOperGravadas' => 100,
            'mtoIGV' => 18,
            'totalImpuestos' => 18,
            'valorVenta' => 100,
            'subTotal' => 118,
            'mtoImpVenta' => 118,
            'monto_letras' => 'CIENTO DIECIOCHO CON 00/100 SOLES',
        ], $overrides));
    }
}
