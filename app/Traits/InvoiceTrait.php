<?php

namespace App\Traits;

use App\Models\Configuration\Company;
use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\DespatcheDetail;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\InvoiceDetail;
use App\Models\Facturacion\Ticket;
use App\Models\Facturacion\TicketDetail;
use App\Models\Package\Encomienda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Luecano\NumeroALetras\NumeroALetras;

trait InvoiceTrait
{
    public function storeInvoce(Encomienda $encomienda)
    {
        $this->setTicket($encomienda);
        if (in_array($encomienda->tipo_comprobante, ['FACTURA', 'BOLETA'])) {
            $this->setInvoice($encomienda, $encomienda->tipo_comprobante);
        }
        $docsTraslado = collect(json_decode($encomienda->docsTraslado, true));
        if (!$docsTraslado->isEmpty() || $encomienda->tipo_comprobante !== 'TICKET') {
            $this->setGuiTrans($encomienda);
        }
    }
    private function setTicket(Encomienda $encomienda)
    {
        $company = Company::first();
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;

        $ticket = Ticket::create([
            'encomienda_id' => $encomienda->id,
            'tipoDoc' => 'TICKET',
            'tipoOperacion' => 'TICKET',
            'serie' => $encomienda->code,
            'correlativo' => Ticket::count() + 1,
            'fechaEmision' => Carbon::now(),
            'formaPago_moneda' => 'PEN',
            'formaPago_tipo' => $encomienda->tipo_pago,
            'tipoMoneda' => 'PEN',
            'company_id' => $company->id,
            'client_id' => $encomienda->customer_id,
            'mtoOperGravadas' => $mtoOperGravadas,
            'mtoIGV' => $igv,
            'totalImpuestos' => $igv,
            'valorVenta' => $mtoOperGravadas,
            'subTotal' => $montoTotalIncIGV,
            'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
        ]);
        $encomienda->doc_ticket = $ticket->id;
        $encomienda->save();
        foreach ($encomienda->paquetes as $paquete) {
            $this->createTicketDetail($ticket->id, $paquete);
        }
    }
    private function createTicketDetail($ticketId, $paquete)
    {
        $mtoValorUnitario = round($paquete->amount / 1.18, 2);
        TicketDetail::create([
            'ticket_id' => $ticketId,
            'tipAfeIgv' => '10',
            'codProducto' => $paquete->id,
            'unidad' => $paquete->und_medida,
            'descripcion' => 'SERVICIO DE TRASLADO ' . $paquete->description,
            'cantidad' => $paquete->cantidad,
            'mtoValorUnitario' => $mtoValorUnitario,
            'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
            'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
            'porcentajeIgv' => 18,
            'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
            'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
            'mtoPrecioUnitario' => $paquete->amount,
        ]);
    }
    private function setInvoice(Encomienda $encomienda, $tipo_comprobante)
    {
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $formatter = new NumeroALetras();
        $monto_letras = $formatter->toInvoice($montoTotalIncIGV, 2, 'SOLES');

        $invoiceData = $this->getInvoiceData($tipo_comprobante, $encomienda, $montoTotalIncIGV, $mtoOperGravadas, $igv, $monto_letras);
        $invoice = Invoice::create($invoiceData);
        $encomienda->doc_factura = $invoice->id;
        $encomienda->save();
        foreach ($encomienda->paquetes as $paquete) {
            $this->createInvoiceDetail($invoice->id, $paquete);
        }
    }
    private function getInvoiceData($tipo_comprobante, $encomienda, $montoTotalIncIGV, $mtoOperGravadas, $igv, $monto_letras)
    {
        $company = Company::first();
        $data = [
            'encomienda_id' => $encomienda->id,
            'sucursal_id' => Auth::user()->sucursal->id,
            'fechaEmision' => Carbon::now(),
            'formaPago_moneda' => 'PEN',
            'formaPago_tipo' => $encomienda->tipo_pago,
            'tipoMoneda' => 'PEN',
            'company_id' => $company->id,
            'client_id' => $encomienda->customer_fact_id,
            'mtoOperGravadas' => $mtoOperGravadas,
            'mtoIGV' => $igv,
            'totalImpuestos' => $igv,
            'valorVenta' => $mtoOperGravadas,
            'subTotal' => $montoTotalIncIGV,
            'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
            'monto_letras' => $monto_letras ?? '',
            'observacion' => $encomienda->observation ?? '',
        ];
        $legends[] = [
            'code' => '1000',
            'value' => $monto_letras,
        ];
        if ($tipo_comprobante == 'BOLETA') {
            $data['serie'] = Auth::user()->sucursal->serieBoleta;
            $data['tipoDoc'] = '03';
            $data['tipoOperacion'] = '0101';
            $data['correlativo'] = Invoice::where('tipoDoc', $data['tipoDoc'])->where('serie', $data['serie'])->count() + 1;
        } else {
            $data['serie'] = Auth::user()->sucursal->serieFactura;
            $data['tipoDoc'] = '01';
            $data['correlativo'] = Invoice::where('tipoDoc', $data['tipoDoc'])->where('serie', $data['serie'])->count() + 1;
            if ($montoTotalIncIGV >= 400) {
                $data['tipoOperacion'] = '1001';
                $data['codBienDetraccion'] = '027';
                $data['codMedioPago'] = '001';
                $data['ctaBanco'] = $company->ctaBanco;
                $data['setPercent'] = 4;
                $data['setMount'] = $montoTotalIncIGV * 0.04;
                $legends[] = [
                    'code' => '2006',
                    'value' => 'Leyenda "Operación sujeta a detracción"',
                ];
            } else {
                $data['tipoOperacion'] = '0101';
            }
        }
        $data['legends'] = json_encode($legends);
        return $data;
    }
    private function createInvoiceDetail($invoiceId, $paquete)
    {
        $mtoValorUnitario = round($paquete->amount / 1.18, 2);
        InvoiceDetail::create([
            'invoice_id' => $invoiceId,
            'tipAfeIgv' => '10',
            'codProducto' => $paquete->id,
            'unidad' => $paquete->und_medida,
            'descripcion' => 'SERVICIO TRASLADO ' . $paquete->description,
            'cantidad' => $paquete->cantidad,
            'mtoValorUnitario' => $mtoValorUnitario,
            'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
            'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
            'porcentajeIgv' => 18,
            'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
            'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
            'mtoPrecioUnitario' => $paquete->amount,
        ]);
    }
    private function setGuiTrans(Encomienda $encomienda)
    {   //dd($encomienda);
        $company = Company::first();
        $correlativo = Despatche::count() + 1;
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $formatter = new NumeroALetras();
        $monto_letras = $formatter->toInvoice($montoTotalIncIGV, 2, 'SOLES');
        $despatch = Despatche::create([
            'encomienda_id' => $encomienda->id,
            'tipoDoc' => '31',
            'serie' => 'V001',
            'correlativo' => $correlativo,
            'fechaEmision' => Carbon::now(),
            'company_id' => $company->id,
            'flete_id' => $encomienda->remitente->id,
            'remitente_id' => $encomienda->remitente->id,
            'destinatario_id' => $encomienda->destinatario->id,
            'codTraslado' => '01',
            'modTraslado' => '02',

            'docsTraslado' => $encomienda->docsTraslado,

            'fecTraslado' => Carbon::now(),
            'pesoTotal' => $encomienda->paquetes->sum('peso'),
            'undPesoTotal' => 'KGM',
            'llegada_ubigueo' => $encomienda->sucursal_destinatario->ubigeo ?? '150203',
            'llegada_direccion' => $encomienda->sucursal_destinatario->address ?? 'Av. Villa Nueva 221',
            'partida_ubigueo' => $encomienda->sucursal_remitente->ubigeo ?? '150101',
            'partida_direccion' => $encomienda->sucursal_remitente->address ?? 'Av. Villa Nueva 221',
            'chofer_tipoDoc' => $encomienda->transportista->type_code ?? '03',
            'chofer_nroDoc' => $encomienda->transportista->dni ?? '4364990',
            'chofer_licencia' => $encomienda->transportista->licencia ?? '1234567890',
            'chofer_nombres' => $encomienda->transportista->name ?? 'Juan',
            'chofer_apellidos' => $encomienda->transportista->name,
            'vehiculo_placa' => $encomienda->vehiculo->name,
            'monto_letras' => $monto_letras,
            'setPercent' => 4,
            'setMount' => $montoTotalIncIGV * 0.04,
            'mtoIGV' => $igv,
            'valorVenta' => $mtoOperGravadas,
            'mtoImpVenta' => $montoTotalIncIGV,

        ]);
        $encomienda->doc_guia = $despatch->id;
        $encomienda->save();
        foreach ($encomienda->paquetes as $paquete) {
            $this->createDespatcheDetail($despatch->id, $paquete);
        }
    }
    private function createDespatcheDetail($despatcheId, $paquete)
    {
        $mtoValorUnitario = round($paquete->amount / 1.18, 2);
        DespatcheDetail::create([
            'despatche_id' => $despatcheId,
            'tipAfeIgv' => '10',
            'codProducto' => $paquete->id,
            'unidad' => $paquete->und_medida,
            'descripcion' => 'SERVICIO TRASLADO ' . $paquete->description,
            'cantidad' => $paquete->cantidad,
            'mtoValorUnitario' => $mtoValorUnitario,
            'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
            'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
            'porcentajeIgv' => 18,
            'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
            'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
            'mtoPrecioUnitario' => $paquete->amount,
        ]);
    }
}
