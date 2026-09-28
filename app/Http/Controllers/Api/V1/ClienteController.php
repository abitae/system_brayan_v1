<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\pdfController;
use App\Http\Resources\EncomiendaResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Facturacion\Invoice;
use App\Models\Package\Encomienda;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClienteController extends Controller
{
    public function encomiendas(Request $request): AnonymousResourceCollection
    {
        $customerId = $this->customerId($request);

        $encomiendas = $this->delCliente($customerId)
            ->with(['remitente', 'destinatario', 'facturacion', 'sucursal_remitente', 'sucursal_destinatario', 'paquetes'])
            ->latest('id')
            ->paginate(20);

        return EncomiendaResource::collection($encomiendas);
    }

    public function comprobantes(Request $request): AnonymousResourceCollection
    {
        $comprobantes = Invoice::query()
            ->where('client_id', $this->customerId($request))
            ->whereIn('tipoDoc', ['01', '03'])
            ->latest('id')
            ->paginate(20);

        return InvoiceResource::collection($comprobantes);
    }

    public function cuentasPorPagar(Request $request): AnonymousResourceCollection
    {
        $encomiendas = Encomienda::query()
            ->with(['remitente', 'destinatario', 'facturacion'])
            ->where('customer_fact_id', $this->customerId($request))
            ->where('estado_credito', 'Pendiente')
            ->where('estado_pago', '!=', 'PAGADO')
            ->latest('id')
            ->paginate(20);

        return EncomiendaResource::collection($encomiendas);
    }

    public function cuentasPagadas(Request $request): AnonymousResourceCollection
    {
        $customerId = $this->customerId($request);

        $encomiendas = Encomienda::query()
            ->with(['remitente', 'destinatario', 'facturacion'])
            ->where('customer_fact_id', $customerId)
            ->where(function ($query) {
                $query->where('estado_pago', 'PAGADO')
                    ->orWhere('estado_credito', 'Cancelado');
            })
            ->latest('id')
            ->paginate(20);

        return EncomiendaResource::collection($encomiendas);
    }

    public function comprobantePdf(Request $request, Invoice $invoice)
    {
        abort_unless((int) $invoice->client_id === $this->customerId($request), 403);
        abort_unless(in_array($invoice->tipoDoc, ['01', '03'], true), 404);

        return app(pdfController::class)->invoiceA4($invoice);
    }

    private function customerId(Request $request): int
    {
        abort_unless($request->user()->customer_id, 403);

        return (int) $request->user()->customer_id;
    }

    private function delCliente(int $customerId)
    {
        return Encomienda::query()->where(function ($query) use ($customerId) {
            $query->where('customer_id', $customerId)
                ->orWhere('customer_dest_id', $customerId)
                ->orWhere('customer_fact_id', $customerId);
        });
    }
}
