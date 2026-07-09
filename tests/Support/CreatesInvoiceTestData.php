<?php

namespace Tests\Support;

use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Facturacion\Invoice;
use App\Models\Package\Customer;
use Carbon\Carbon;

trait CreatesInvoiceTestData
{
    protected function createInvoiceFixture(array $invoiceOverrides = []): Invoice
    {
        $company = Company::forceCreate([
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

        $sucursal = Sucursal::create([
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
            'departamento' => 'LIMA',
            'provincia' => 'LIMA',
            'distrito' => 'LIMA',
            'address' => 'Av. Test 456',
            'ubigeo' => '150101',
            'isActive' => true,
        ]);

        $client = Customer::create([
            'type_code' => '6',
            'code' => '20123456789',
            'name' => 'CLIENTE TEST',
            'phone' => '999888777',
            'email' => 'cliente@test.pe',
            'address' => 'Jr. Cliente 1',
            'ubigeo' => '150101',
            'isActive' => true,
        ]);

        return Invoice::create(array_merge([
            'company_id' => $company->id,
            'sucursal_id' => $sucursal->id,
            'client_id' => $client->id,
            'tipoDoc' => '01',
            'tipoOperacion' => '0101',
            'serie' => 'F001',
            'correlativo' => '1',
            'fechaEmision' => Carbon::now('America/Lima')->toDateTimeString(),
            'formaPago_moneda' => 'PEN',
            'formaPago_tipo' => 'Contado',
            'tipoMoneda' => 'PEN',
            'mtoOperGravadas' => 100.00,
            'mtoIGV' => 18.00,
            'totalImpuestos' => 18.00,
            'valorVenta' => 100.00,
            'subTotal' => 118.00,
            'mtoImpVenta' => 118.00,
            'monto_letras' => 'CIENTO DIECIOCHO CON 00/100 SOLES',
            'cdr_code' => '0',
            'cdr_description' => 'Aceptado',
        ], $invoiceOverrides));
    }
}
