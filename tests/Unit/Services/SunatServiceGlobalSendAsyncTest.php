<?php

namespace Tests\Unit\Services;

use App\Services\SunatServiceGlobal;
use Greenter\Factory\FeFactory;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\Error;
use Greenter\See;
use Mockery;
use Tests\TestCase;

class SunatServiceGlobalSendAsyncTest extends TestCase
{
    public function test_send_async_document_returns_cdr_on_success(): void
    {
        $document = Mockery::mock(DocumentInterface::class);
        $document->shouldReceive('getName')->andReturn('20123456789-RA-20260709-00001');

        $sendResult = Mockery::mock(BaseResult::class);
        $sendResult->shouldReceive('isSuccess')->andReturn(true);
        $sendResult->shouldReceive('getTicket')->andReturn('TICKET-123');

        $cdrResponse = Mockery::mock(CdrResponse::class);
        $cdrResponse->shouldReceive('getCode')->andReturn(0);
        $cdrResponse->shouldReceive('getDescription')->andReturn('La Comunicacion de baja ha sido aceptada');
        $cdrResponse->shouldReceive('getNotes')->andReturn([]);

        $statusResult = Mockery::mock(StatusResult::class);
        $statusResult->shouldReceive('isSuccess')->andReturn(true);
        $statusResult->shouldReceive('getCdrResponse')->andReturn($cdrResponse);
        $statusResult->shouldReceive('getCdrZip')->andReturn('ZIP-CDR-CONTENT');

        $factory = Mockery::mock(FeFactory::class);
        $factory->shouldReceive('getLastXml')->andReturn('<xml/>');

        $see = Mockery::mock(See::class);
        $see->shouldReceive('send')->once()->with($document)->andReturn($sendResult);
        $see->shouldReceive('getFactory')->andReturn($factory);
        $see->shouldReceive('getStatus')->once()->with('TICKET-123')->andReturn($statusResult);

        $service = new SunatServiceGlobal();
        $response = $service->sendAsyncDocument($see, $document);

        $this->assertTrue($response['success']);
        $this->assertSame('TICKET-123', $response['ticket']);
        $this->assertSame('ZIP-CDR-CONTENT', $response['cdrZip']);
        $this->assertSame(0, $response['cdrResponse']['code']);
    }

    public function test_send_async_document_returns_error_when_send_fails(): void
    {
        $document = Mockery::mock(DocumentInterface::class);
        $document->shouldReceive('getName')->andReturn('20123456789-RA-20260709-00001');

        $error = Mockery::mock(Error::class);
        $error->shouldReceive('getCode')->andReturn('HTTP');
        $error->shouldReceive('getMessage')->andReturn('Error de conexion');

        $sendResult = Mockery::mock(BaseResult::class);
        $sendResult->shouldReceive('isSuccess')->andReturn(false);
        $sendResult->shouldReceive('getError')->andReturn($error);

        $see = Mockery::mock(See::class);
        $see->shouldReceive('send')->once()->with($document)->andReturn($sendResult);

        $service = new SunatServiceGlobal();
        $response = $service->sendAsyncDocument($see, $document);

        $this->assertFalse($response['success']);
        $this->assertSame('HTTP', $response['error']['code']);
    }
}
