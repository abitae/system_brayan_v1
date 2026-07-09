<?php

namespace Tests\Unit\Services;

use App\Services\SunatServiceGlobal;
use Greenter\See;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Tests\Support\CreatesInvoiceTestData;
use Tests\TestCase;

class SunatServiceGlobalAnulacionTest extends TestCase
{
    use CreatesInvoiceTestData;
    use DatabaseTransactions;

    public function test_next_sunat_correlativo_returns_sequential_values_per_day(): void
    {
        if (! extension_loaded('pdo_sqlite') && ! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('No PDO database driver available');
        }

        $invoice = $this->createInvoiceFixture();
        $service = new SunatServiceGlobal();

        $this->assertSame('00001', $service->nextSunatCorrelativo($invoice->company_id));

        $invoice->update([
            'baja_ticket' => 'TICKET-001',
            'updated_at' => now('America/Lima'),
        ]);

        $this->assertSame('00002', $service->nextSunatCorrelativo($invoice->company_id));
    }

    public function test_send_async_document_returns_cdr_on_success(): void
    {
        $this->markTestSkipped('Covered by SunatServiceGlobalSendAsyncTest');
    }

    public function test_send_async_document_returns_error_when_send_fails(): void
    {
        $this->markTestSkipped('Covered by SunatServiceGlobalSendAsyncTest');
    }

    public function test_anular_factura_sunat_delegates_to_send_async_document(): void
    {
        if (! extension_loaded('pdo_sqlite') && ! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('No PDO database driver available');
        }

        $invoice = $this->createInvoiceFixture(['tipoDoc' => '01']);

        $service = Mockery::mock(SunatServiceGlobal::class)->makePartial();
        $service->shouldReceive('getSee')->once()->andReturn(Mockery::mock(See::class));
        $service->shouldReceive('nextSunatCorrelativo')->once()->andReturn('00001');
        $service->shouldReceive('sendAsyncDocument')->once()->andReturn([
            'success' => true,
            'ticket' => 'TICKET-F001',
            'documentName' => '20123456789-RA-20260709-00001',
            'cdrResponse' => ['code' => 0, 'description' => 'OK', 'notes' => []],
            'cdrZip' => 'zip',
        ]);

        $response = $service->anularFacturaSunat($invoice, 'Anulacion de la operacion');

        $this->assertTrue($response['success']);
        $this->assertSame('TICKET-F001', $response['ticket']);
    }

    public function test_anular_boleta_sunat_delegates_to_send_async_document(): void
    {
        if (! extension_loaded('pdo_sqlite') && ! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('No PDO database driver available');
        }

        $invoice = $this->createInvoiceFixture([
            'tipoDoc' => '03',
            'serie' => 'B001',
        ]);

        $service = Mockery::mock(SunatServiceGlobal::class)->makePartial();
        $service->shouldReceive('getSee')->once()->andReturn(Mockery::mock(See::class));
        $service->shouldReceive('nextSunatCorrelativo')->once()->andReturn('00001');
        $service->shouldReceive('sendAsyncDocument')->once()->andReturn([
            'success' => true,
            'ticket' => 'TICKET-B001',
            'documentName' => '20123456789-RC-20260709-00001',
            'cdrResponse' => ['code' => 0, 'description' => 'OK', 'notes' => []],
            'cdrZip' => 'zip',
        ]);

        $response = $service->anularBoletaSunat($invoice);

        $this->assertTrue($response['success']);
        $this->assertSame('TICKET-B001', $response['ticket']);
    }
}
