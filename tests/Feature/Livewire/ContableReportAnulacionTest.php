<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Report\ContableReport;
use App\Models\Facturacion\Invoice;
use App\Services\SunatServiceGlobal;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Mockery;
use Tests\Support\CreatesInvoiceTestData;
use Tests\TestCase;

class ContableReportAnulacionTest extends TestCase
{
    use CreatesInvoiceTestData;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        if (! extension_loaded('pdo_sqlite') && ! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('No PDO database driver available');
        }

        Storage::fake('public');
    }

    public function test_no_anula_si_ya_esta_anulado(): void
    {
        $invoice = $this->createInvoiceFixture(['estado' => 'ANULADO']);

        Livewire::test(ContableReport::class)
            ->call('anularComprobante', $invoice->id, 'Anulacion de la operacion')
            ->assertNotified();

        $invoice->refresh();
        $this->assertSame('ANULADO', $invoice->estado);
        $this->assertNull($invoice->baja_ticket);
    }

    public function test_no_anula_si_cdr_no_es_aceptado(): void
    {
        $invoice = $this->createInvoiceFixture(['cdr_code' => null]);

        Livewire::test(ContableReport::class)
            ->call('anularComprobante', $invoice->id, 'Anulacion de la operacion')
            ->assertNotified();

        $invoice->refresh();
        $this->assertNull($invoice->estado);
    }

    public function test_no_anula_fuera_de_plazo_de_siete_dias(): void
    {
        $invoice = $this->createInvoiceFixture([
            'fechaEmision' => Carbon::now('America/Lima')->subDays(8)->toDateTimeString(),
        ]);

        Livewire::test(ContableReport::class)
            ->call('anularComprobante', $invoice->id, 'Anulacion de la operacion')
            ->assertNotified();

        $invoice->refresh();
        $this->assertNull($invoice->estado);
    }

    public function test_anula_factura_exitosamente_sin_sobrescribir_cdr_original(): void
    {
        $invoice = $this->createInvoiceFixture([
            'tipoDoc' => '01',
            'cdr_path' => 'cdr/original.zip',
            'cdr_code' => '0',
        ]);

        $mock = Mockery::mock(SunatServiceGlobal::class);
        $mock->shouldReceive('anularFacturaSunat')
            ->once()
            ->with(Mockery::on(fn ($inv) => $inv->id === $invoice->id), 'Anulacion de la operacion')
            ->andReturn([
                'success' => true,
                'ticket' => 'TICKET-OK',
                'documentName' => '20123456789-RA-20260709-00001',
                'cdrResponse' => [
                    'code' => 0,
                    'description' => 'Aceptado',
                    'notes' => [],
                ],
                'cdrZip' => 'zip-baja-content',
            ]);

        $this->app->instance(SunatServiceGlobal::class, $mock);

        Livewire::test(ContableReport::class)
            ->call('anularComprobante', $invoice->id, 'Anulacion de la operacion')
            ->assertNotified();

        $invoice->refresh();

        $this->assertSame('ANULADO', $invoice->estado);
        $this->assertSame('TICKET-OK', $invoice->baja_ticket);
        $this->assertSame('Anulacion de la operacion', $invoice->baja_motivo);
        $this->assertSame('cdr/original.zip', $invoice->cdr_path);
        $this->assertSame('0', $invoice->cdr_code);
        $this->assertNotNull($invoice->baja_cdr_path);
        Storage::disk('public')->assertExists($invoice->baja_cdr_path);
    }

    public function test_anula_boleta_usando_resumen_diario(): void
    {
        $invoice = $this->createInvoiceFixture([
            'tipoDoc' => '03',
            'serie' => 'B001',
            'cdr_code' => '0',
        ]);

        $mock = Mockery::mock(SunatServiceGlobal::class);
        $mock->shouldReceive('anularBoletaSunat')
            ->once()
            ->with(Mockery::on(fn ($inv) => $inv->id === $invoice->id))
            ->andReturn([
                'success' => true,
                'ticket' => 'TICKET-BOLETA',
                'documentName' => '20123456789-RC-20260709-00001',
                'cdrResponse' => [
                    'code' => 0,
                    'description' => 'Aceptado',
                    'notes' => [],
                ],
                'cdrZip' => 'zip-boleta-baja',
            ]);

        $this->app->instance(SunatServiceGlobal::class, $mock);

        Livewire::test(ContableReport::class)
            ->call('anularComprobante', $invoice->id, 'Anulacion de la operacion')
            ->assertNotified();

        $invoice->refresh();
        $this->assertSame('ANULADO', $invoice->estado);
        $this->assertSame('TICKET-BOLETA', $invoice->baja_ticket);
    }

    public function test_ejecutar_anulacion_valida_motivo_minimo(): void
    {
        $invoice = $this->createInvoiceFixture();

        Livewire::test(ContableReport::class)
            ->set('invoiceAnularId', $invoice->id)
            ->set('motivoBaja', 'abc')
            ->call('ejecutarAnulacion')
            ->assertHasErrors(['motivoBaja']);
    }
}
