<?php

namespace Tests\Feature\Livewire;

use App\Exports\ReportVentasExport;
use App\Livewire\Report\VentasReport;
use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\InvoiceDetail;
use App\Models\Facturacion\Note;
use App\Models\Facturacion\NoteDetail;
use App\Models\Package\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class VentasReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (! extension_loaded('pdo_sqlite') && ! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('No PDO database driver available');
        }
    }

    public function test_filtro_mes_aplica_inicio_y_fin_del_mes(): void
    {
        $company = $this->createCompany();
        $sucursal = $this->createSucursal('SUC01');
        $client = $this->createCustomer();

        $inside = $this->createInvoice($company, $sucursal, $client, [
            'fechaEmision' => '2024-07-31 23:59:59',
            'correlativo' => '10',
        ]);
        $this->createInvoiceDetail($inside, ['descripcion' => 'SERVICIO JULIO']);

        $outside = $this->createInvoice($company, $sucursal, $client, [
            'fechaEmision' => '2024-08-01 00:00:00',
            'correlativo' => '11',
        ]);
        $this->createInvoiceDetail($outside, ['descripcion' => 'SERVICIO AGOSTO']);

        $rows = Livewire::test(VentasReport::class)
            ->set('filtroMes', '2024-07')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(1, $rows);
        $this->assertSame('SERVICIO JULIO', $rows[0]['articulo']);
    }

    public function test_genera_filas_de_facturas_por_detalle(): void
    {
        $company = $this->createCompany();
        $sucursal = $this->createSucursal('SUC01');
        $client = $this->createCustomer();
        $invoice = $this->createInvoice($company, $sucursal, $client, [
            'fechaEmision' => '2024-07-10 09:00:00',
            'tipoDoc' => '01',
            'serie' => 'F001',
            'correlativo' => '123',
        ]);

        $this->createInvoiceDetail($invoice, [
            'descripcion' => 'ENVIO LIMA',
            'cantidad' => 2,
            'mtoValorVenta' => 100,
            'igv' => 18,
            'mtoPrecioUnitario' => 59,
        ]);

        $rows = Livewire::test(VentasReport::class)
            ->set('filtroMes', '2024-07')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(1, $rows);
        $this->assertSame('1', $rows[0]['tipo_doc_tabla']);
        $this->assertSame('F001', $rows[0]['serie']);
        $this->assertSame('ENVIO LIMA', $rows[0]['articulo']);
        $this->assertSame(100.0, $rows[0]['base_gravada']);
        $this->assertSame(18.0, $rows[0]['igv']);
        $this->assertSame(118.0, $rows[0]['importe_total']);
    }

    public function test_nota_de_credito_sale_negativa_y_con_referencia(): void
    {
        $company = $this->createCompany();
        $sucursal = $this->createSucursal('SUC01');
        $client = $this->createCustomer();
        $note = $this->createNote($company, $sucursal, $client, [
            'tipoDoc' => '07',
            'serie' => 'FC01',
            'correlativo' => '5',
            'fechaEmision' => '2024-07-12',
            'tipoDocAfectado' => '01',
            'numDocfectado' => 'F001-123',
        ]);

        $this->createNoteDetail($note, [
            'descripcion' => 'ANULACION PARCIAL',
            'cantidad' => 1,
            'mtoValorVenta' => 50,
            'igv' => 9,
            'mtoPrecioUnitario' => 59,
        ]);

        $rows = Livewire::test(VentasReport::class)
            ->set('filtroMes', '2024-07')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(1, $rows);
        $this->assertSame(-50.0, $rows[0]['base_gravada']);
        $this->assertSame(-9.0, $rows[0]['igv']);
        $this->assertSame(-59.0, $rows[0]['importe_total']);
        $this->assertSame('1', $rows[0]['ref_tipo']);
        $this->assertSame('F001', $rows[0]['ref_serie']);
        $this->assertSame('123', $rows[0]['ref_numero']);
    }

    public function test_filtra_por_invoices_y_notes(): void
    {
        $company = $this->createCompany();
        $sucursal = $this->createSucursal('SUC01');
        $client = $this->createCustomer();

        $invoice = $this->createInvoice($company, $sucursal, $client, [
            'fechaEmision' => '2024-07-10 09:00:00',
            'serie' => 'F001',
            'correlativo' => '1',
        ]);
        $this->createInvoiceDetail($invoice, ['descripcion' => 'INVOICE ROW']);

        $note = $this->createNote($company, $sucursal, $client, [
            'fechaEmision' => '2024-07-11',
            'serie' => 'FC01',
            'correlativo' => '1',
        ]);
        $this->createNoteDetail($note, ['descripcion' => 'NOTE ROW']);

        $component = Livewire::test(VentasReport::class)
            ->set('filtroMes', '2024-07');

        $invoiceRows = $component
            ->set('filtroOrigen', 'invoices')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(1, $invoiceRows);
        $this->assertSame('INVOICE ROW', $invoiceRows[0]['articulo']);

        $noteRows = $component
            ->set('filtroOrigen', 'notes')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(1, $noteRows);
        $this->assertSame('NOTE ROW', $noteRows[0]['articulo']);

        $allRows = $component
            ->set('filtroOrigen', 'todos')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(2, $allRows);
    }

    public function test_usuario_de_sucursal_solo_ve_su_sucursal(): void
    {
        $company = $this->createCompany();
        $sucursalA = $this->createSucursal('SUC01');
        $sucursalB = $this->createSucursal('SUC02');
        $client = $this->createCustomer();
        $user = User::factory()->create(['sucursal_id' => $sucursalA->id]);

        $invoiceA = $this->createInvoice($company, $sucursalA, $client, [
            'fechaEmision' => '2024-07-10 09:00:00',
            'correlativo' => '1',
        ]);
        $this->createInvoiceDetail($invoiceA, ['descripcion' => 'SUCURSAL A']);

        $invoiceB = $this->createInvoice($company, $sucursalB, $client, [
            'fechaEmision' => '2024-07-10 09:00:00',
            'correlativo' => '2',
        ]);
        $this->createInvoiceDetail($invoiceB, ['descripcion' => 'SUCURSAL B']);

        $rows = Livewire::actingAs($user)
            ->test(VentasReport::class)
            ->set('filtroMes', '2024-07')
            ->call('refreshRows')
            ->get('rows');

        $this->assertCount(1, $rows);
        $this->assertSame('SUCURSAL A', $rows[0]['articulo']);
    }

    public function test_descarga_excel_con_nombre_mensual(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-07-15 10:11:12', 'America/Lima'));
        Excel::fake();

        $company = $this->createCompany();
        $sucursal = $this->createSucursal('SUC01');
        $client = $this->createCustomer();
        $invoice = $this->createInvoice($company, $sucursal, $client, [
            'fechaEmision' => '2024-07-10 09:00:00',
        ]);
        $this->createInvoiceDetail($invoice);

        Livewire::test(VentasReport::class)
            ->set('filtroMes', '2024-07')
            ->call('excelGenerate');

        Excel::assertDownloaded(
            'registro_ventas_202407_20240715_101112.xlsx',
            fn (ReportVentasExport $export) => count($export->rows) === 1
                && $export->periodoInicio->format('Y-m-d') === '2024-07-01'
                && $export->periodoFin->format('Y-m-d') === '2024-07-31'
        );

        Carbon::setTestNow();
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

    private function createSucursal(string $code): Sucursal
    {
        return Sucursal::create([
            'code' => $code,
            'codeSunat' => '0000',
            'igv' => 18,
            'serieFactura' => 'F001',
            'serieBoleta' => 'B001',
            'serieGuiaRemision' => 'T001',
            'serieNotaCreditoFactura' => 'FC01',
            'serieNotaCreditoBoleta' => 'BC01',
            'serieNotaDebitoFactura' => 'FD01',
            'serieNotaDebitoBoleta' => 'BD01',
            'name' => 'Sucursal '.$code,
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
            'cdr_code' => '0',
            'cdr_description' => 'Aceptado',
        ], $overrides));
    }

    private function createInvoiceDetail(Invoice $invoice, array $overrides = []): InvoiceDetail
    {
        return InvoiceDetail::create(array_merge([
            'invoice_id' => $invoice->id,
            'tipAfeIgv' => '10',
            'codProducto' => 'SERV',
            'unidad' => 'NIU',
            'descripcion' => 'SERVICIO TEST',
            'cantidad' => 1,
            'mtoValorUnitario' => 100,
            'mtoValorVenta' => 100,
            'mtoBaseIgv' => 100,
            'porcentajeIgv' => 18,
            'igv' => 18,
            'totalImpuestos' => 18,
            'mtoPrecioUnitario' => 118,
        ], $overrides));
    }

    private function createNote(Company $company, Sucursal $sucursal, Customer $client, array $overrides = []): Note
    {
        return Note::create(array_merge([
            'company_id' => $company->id,
            'sucursal_id' => $sucursal->id,
            'customer_id' => $client->id,
            'ublVersion' => '2.1',
            'tipoDoc' => '07',
            'serie' => 'FC01',
            'correlativo' => '1',
            'fechaEmision' => '2024-07-10',
            'tipoDocAfectado' => '01',
            'numDocfectado' => 'F001-1',
            'codMotivo' => '01',
            'desMotivo' => 'Anulacion de la operacion',
            'tipoMoneda' => 'PEN',
            'mtoOperGravadas' => 50,
            'mtoIGV' => 9,
            'totalImpuestos' => 9,
            'mtoImpVenta' => 59,
            'monto_letras' => 'CINCUENTA Y NUEVE CON 00/100 SOLES',
            'cdr_code' => '0',
            'cdr_description' => 'Aceptado',
        ], $overrides));
    }

    private function createNoteDetail(Note $note, array $overrides = []): NoteDetail
    {
        return NoteDetail::create(array_merge([
            'note_id' => $note->id,
            'tipAfeIgv' => '10',
            'codProducto' => 'SERV',
            'unidad' => 'NIU',
            'descripcion' => 'NOTA TEST',
            'cantidad' => 1,
            'mtoValorUnitario' => 50,
            'mtoValorVenta' => 50,
            'mtoBaseIgv' => 50,
            'porcentajeIgv' => 18,
            'igv' => 9,
            'totalImpuestos' => 9,
            'mtoPrecioUnitario' => 59,
        ], $overrides));
    }
}
