<?php

namespace App\Livewire\Facturacion;

use App\Exports\InvoiceExport;
use App\Models\Facturacion\Invoice;
use App\Services\SunatServiceGlobal;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Greenter\Report\XmlUtils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class InvoiceLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    use UtilsTrait;
    public string $title = 'BOLETAS Y FACTURAS';
    public string $sub_title = 'Modulo de facturacion electronica';
    public int $perPage = 20;
    public $infoModal = false;
    public $num_invoices = 0;
    public $cdr_code;
    public $cdr_description;
    public $cdr_note;
    public $errorCode;
    public $errorMessage;

    public $filtroFechaInicio;
    public $filtroFechaFin;
    public $search;
    public $FiltroFormaPagoTipo = 'Todos';
    public $formaPagos = [
        ['id' => 'Todos', 'name' => 'Todos'],
        ['id' => 'Contado', 'name' => 'Contado'],
        ['id' => 'Credito', 'name' => 'Credito'],
    ];
    public function mount()
    {
        $this->filtroFechaInicio = $this->filterDateStart();
        $this->filtroFechaFin = $this->filterDateEnd();
    }

    public function updatedFiltroFechaInicio(): void
    {
        $this->ensureDateRangeOrder($this->filtroFechaInicio, $this->filtroFechaFin);
    }

    public function updatedFiltroFechaFin(): void
    {
        $this->ensureDateRangeOrder($this->filtroFechaInicio, $this->filtroFechaFin);
    }

    public function render()
    {
        $invoices = $this->invoicesQuery()->paginate($this->perPage);

        return view('livewire.facturacion.invoice-live', compact('invoices'));
    }

    public function excelGenerate()
    {
        $invoices = $this->invoicesQuery()
            ->with(['client', 'encomienda'])
            ->get();

        if ($invoices->isEmpty()) {
            $this->toast('warning', 'No hay comprobantes para exportar en el rango seleccionado');

            return null;
        }

        $totalBase = round($invoices->sum(fn (Invoice $invoice) => (float) $invoice->mtoOperGravadas), 2);
        $totalIgv = round($invoices->sum(fn (Invoice $invoice) => (float) $invoice->mtoIGV), 2);
        $totalVentas = round($invoices->sum(fn (Invoice $invoice) => (float) $invoice->mtoImpVenta), 2);
        $filename = 'reporte_invoices_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        $this->toast('success', 'Generando reporte Excel');

        return Excel::download(
            new InvoiceExport($invoices, $totalBase, $totalIgv, $totalVentas),
            $filename
        );
    }

    private function invoicesQuery()
    {
        return Invoice::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('serie', 'like', '%' . $this->search . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->search . '%')
                        ->orWhereHas('client', function ($query) {
                            $query->where('code', 'like', '%' . $this->search . '%')
                                ->orWhere('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filtroFechaInicio && $this->filtroFechaFin, function ($query) {
                return $query->whereBetween('fechaEmision', [
                    $this->parseFilterDateStart($this->filtroFechaInicio),
                    $this->parseFilterDateEnd($this->filtroFechaFin),
                ]);
            })
            ->when($this->FiltroFormaPagoTipo !== 'Todos', function ($query) {
                return $query->where('formaPago_tipo', $this->FiltroFormaPagoTipo);
            })
            ->latest();
    }
    public function xmlGenerate(Invoice $invoice)
    {
        $invoice->load(['company', 'client', 'details', 'sucursal']);
        $company = $invoice->company;
        $sunat = new SunatServiceGlobal();
        $see = $sunat->getSee($company);
        $invoce = $sunat->getInvoce($invoice);
        $xml = $see->getXmlSigned($invoce);
        $hash = (new XmlUtils())->getHashSign($xml);
        $invoice->xml_hash = $hash;
        $invoice->xml_path = 'xml/' . $invoice->company->ruc . '-' . $invoice->tipoDoc . '-' . $invoice->serie . '-' . $invoice->correlativo . '.xml';
        $invoice->save();
        Storage::disk('public')->put($invoice->xml_path, $xml);
    }
    public function xmlDownload(Invoice $invoice)
    {
        if (Storage::exists($invoice->xml_path)) {
            return response()->download(storage_path('app/public/' . $invoice->xml_path));
        }
    }
    public function sendXmlFile(Invoice $invoice)
    {
        $company = $invoice->company;
        $sunat = new SunatServiceGlobal();
        $see = $sunat->getSee($company);
        if ($invoice->xml_path) {
            $xml = Storage::disk('public')->get($invoice->xml_path);
            $result = $see->sendXmlFile($xml);
        } else {
            $this->toast('error', 'No se encontró el archivo XML');
            return;
        }
        $response = $sunat->sunatResponse($result);
        if ($response['success']) {
            $invoice->cdr_description = $response['cdrResponse']['description'];
            $invoice->cdr_code = $response['cdrResponse']['code'];
            $invoice->cdr_note = $response['cdrResponse']['notes'];
            $invoice->cdr_path = 'cdr/' . 'R-' . $invoice->company->ruc . '-' . $invoice->tipoDoc . '-' . $invoice->serie . '-' . $invoice->correlativo . '.zip';
            $invoice->errorCode = null;
            $invoice->errorMessage = null;
            $invoice->save();
            $cdr = $result->getCdrZip();
            Storage::disk('public')->put($invoice->cdr_path, $cdr);
            $this->toast('success', 'Comprobante enviado a la sunat');
        } else {
            $invoice->errorCode = $response['error']['code'];
            $invoice->errorMessage = $response['error']['message'];
            $invoice->save();
            $this->toast('error', 'Error al enviar el comprobante a la sunat');
        }
    }
    public function downloadCdrFile(Invoice $invoice)
    {
        if (Storage::exists($invoice->cdr_path)) {
            return response()->download(storage_path('app/public/' . $invoice->cdr_path));
        }
    }
    public function refresh($invoice)
    {
        $invoice = Invoice::find($invoice);

        $this->infoModal = true;
    }
    public function statusInvoice($invoice)
    {
        $invoice = Invoice::find($invoice);
        $this->cdr_code = $invoice->cdr_code;
        $this->cdr_description = $invoice->cdr_description;
        $this->cdr_note = $invoice->cdr_note;
        $this->errorCode = $invoice->errorCode;
        $this->errorMessage = $invoice->errorMessage;
        $this->infoModal = true;
    }
    public function createNote(Invoice $invoice)
    {
        $this->redirectRoute(
            'facturacion.create-note',
            ['id' => $invoice->id],
            false,
            false
        );
    }
    public function enviarBloque()
    {
        $invoices = Invoice::whereNull('xml_path')
            ->when($this->filtroFechaInicio && $this->filtroFechaFin, function ($query) {
                return $query->whereBetween('fechaEmision', [
                    $this->parseFilterDateStart($this->filtroFechaInicio),
                    $this->parseFilterDateEnd($this->filtroFechaFin),
                ]);
            })->get();
        if ($invoices->count() != 0) {
            foreach ($invoices as $invoice) {
                $this->xmlGenerate($invoice);
            }
        }
        $invoices = Invoice::whereNull('cdr_path')
            ->whereNotNull('xml_path')
            ->when($this->filtroFechaInicio && $this->filtroFechaFin, function ($query) {
                return $query->whereBetween('fechaEmision', [
                    $this->parseFilterDateStart($this->filtroFechaInicio),
                    $this->parseFilterDateEnd($this->filtroFechaFin),
                ]);
            })->get();
        $this->num_invoices = $invoices->count();
        if ($invoices->count() != 0) {
            foreach ($invoices as $invoice) {
                $this->sendXmlFile($invoice);
            }
        }
        $this->toast('info', 'Enviando ' . $invoices->count() . ' comprobantes');
    }
    public function buscaResumen()
    {
        $invoices = Invoice::whereNull('cdr_path')
            ->where('serie', 'like', 'B%')
            ->get();
        dd($invoices);
    }
    public function sendSummary()
    {
        $invoices = Invoice::whereNull('cdr_path')
            ->where('serie', 'like', 'B%')
            ->get();
        dd($invoices);
        $sunat = new SunatServiceGlobal();
        $see = $sunat->getSee($invoices->first()->company);
        $sum = $sunat->setResumenDiario($invoices);
        $result = $see->send($sum);
        dd($result);
        $response = $sunat->sunatResponse($result);
        if ($response['success']) {
            foreach ($invoices as $invoice) {
                $invoice->cdr_description = $response['cdrResponse']['description'];
                $invoice->cdr_code = $response['cdrResponse']['code'];
                $invoice->cdr_note = $response['cdrResponse']['notes'];
                $invoice->cdr_path = 'cdr/' . 'R-' . $invoice->company->ruc . '-' . $invoice->tipoDoc . '-' . $invoice->serie . '-' . $invoice->correlativo . '.zip';
                $invoice->save();
                Storage::disk('public')->put($invoice->cdr_path, $cdr);
            }
            $this->toast('success', 'Resumen diario enviado a la sunat');
        } else {
            $this->toast('error', 'Error al enviar el resumen diario a la sunat');
        }
    }
}
