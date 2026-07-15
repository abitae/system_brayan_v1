<?php

namespace App\Livewire\Report;

use App\Exports\ReportVentasExport;
use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Note;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class VentasReport extends Component
{
    use Toast, UtilsTrait, WithPagination, WithoutUrlPagination;

    private const DEFAULT_PER_PAGE = 15;

    public string $title = 'REGISTRO DE VENTAS';

    public string $sub_title = 'Reporte mensual de ventas para contabilidad';

    public string $filtroMes = '';

    public ?int $filtroSucursal = null;

    public string $filtroOrigen = 'todos';

    public bool $soloSucursalUsuario = false;

    public int $perPage = self::DEFAULT_PER_PAGE;

    public int $totalDocumentos = 0;

    public int $totalLineas = 0;

    public float $totalBase = 0;

    public float $totalIgv = 0;

    public float $totalVentas = 0;

    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    public function mount(): void
    {
        $this->filtroMes = now('America/Lima')->format('Y-m');

        $user = Auth::user();

        if ($user && ! $this->canViewAllSucursales()) {
            $this->filtroSucursal = $user->sucursal_id;
            $this->soloSucursalUsuario = true;
        }
    }

    public function render()
    {
        $this->refreshRows();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = collect($this->rows)
            ->slice(($currentPage - 1) * $this->perPage, $this->perPage)
            ->values();

        $lineas = new LengthAwarePaginator(
            $items,
            $this->totalLineas,
            $this->perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );

        return view('livewire.report.ventas-report', [
            'lineas' => $lineas,
            'sucursals' => $this->getSucursales(),
            'origenes' => $this->getOrigenes(),
            'periodoInicio' => $this->periodRange()[0],
            'periodoFin' => $this->periodRange()[1],
        ]);
    }

    public function updatedFiltroMes(): void
    {
        if (! preg_match('/^\d{4}-\d{2}$/', $this->filtroMes)) {
            $this->filtroMes = now('America/Lima')->format('Y-m');
        }

        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['filtroSucursal', 'filtroOrigen'], true)) {
            $this->resetPage();
        }
    }

    public function excelGenerate()
    {
        $this->refreshRows();

        if (empty($this->rows)) {
            $this->warning('No hay datos para exportar en el mes seleccionado');

            return null;
        }

        [$inicio, $fin] = $this->periodRange();
        $companyName = Company::query()->value('razonSocial') ?? 'EMPRESA';
        $filename = 'registro_ventas_'.$inicio->format('Ym').'_'.now('America/Lima')->format('Ymd_His').'.xlsx';

        $this->success('Registro de ventas generado con éxito');

        return Excel::download(
            new ReportVentasExport($this->rows, $companyName, $inicio, $fin),
            $filename
        );
    }

    public function refreshRows(): void
    {
        $rows = $this->buildRows();

        $this->rows = $rows->values()->all();
        $this->totalLineas = $rows->count();
        $this->totalDocumentos = $rows->pluck('document_key')->unique()->count();
        $this->totalBase = round($rows->sum('base_gravada'), 2);
        $this->totalIgv = round($rows->sum('igv'), 2);
        $this->totalVentas = round($rows->sum('importe_total'), 2);
    }

    public function buildRows(): Collection
    {
        [$inicio, $fin] = $this->periodRange();

        $invoices = collect();
        $notes = collect();

        if (in_array($this->filtroOrigen, ['todos', 'invoices'], true)) {
            $invoices = Invoice::query()
                ->with(['client', 'details'])
                ->whereBetween('fechaEmision', [$inicio, $fin])
                ->when($this->filtroSucursal, fn ($query) => $query->where('sucursal_id', $this->filtroSucursal))
                ->get()
                ->flatMap(fn (Invoice $invoice) => $this->mapInvoiceRows($invoice));
        }

        if (in_array($this->filtroOrigen, ['todos', 'notes'], true)) {
            $notes = Note::query()
                ->with(['client', 'details'])
                ->whereBetween('fechaEmision', [$inicio, $fin])
                ->when($this->filtroSucursal, fn ($query) => $query->where('sucursal_id', $this->filtroSucursal))
                ->get()
                ->flatMap(fn (Note $note) => $this->mapNoteRows($note));
        }

        return $invoices
            ->concat($notes)
            ->sortBy([
                ['fecha_emision_raw', 'desc'],
                ['tipo_doc', 'asc'],
                ['serie', 'asc'],
                ['numero', 'desc'],
            ])
            ->values();
    }

    private function mapInvoiceRows(Invoice $invoice): Collection
    {
        $details = $invoice->details->isNotEmpty()
            ? $invoice->details
            : collect([(object) [
                'descripcion' => '',
                'cantidad' => 0,
                'tipAfeIgv' => '10',
                'mtoValorVenta' => $invoice->mtoOperGravadas,
                'igv' => $invoice->mtoIGV,
                'mtoPrecioUnitario' => $invoice->mtoImpVenta,
            ]]);

        return $details->map(fn ($detail) => $this->baseRow(
            document: $invoice,
            detail: $detail,
            sign: $invoice->estado === 'ANULADO' ? 0 : 1,
            formaPago: $invoice->formaPago_tipo ?? '-',
        ));
    }

    private function mapNoteRows(Note $note): Collection
    {
        $details = $note->details->isNotEmpty()
            ? $note->details
            : collect([(object) [
                'descripcion' => '',
                'cantidad' => 0,
                'tipAfeIgv' => '10',
                'mtoValorVenta' => $note->mtoOperGravadas,
                'igv' => $note->mtoIGV,
                'mtoPrecioUnitario' => $note->mtoImpVenta,
            ]]);

        $sign = $note->tipoDoc === '07' ? -1 : 1;

        return $details->map(fn ($detail) => $this->baseRow(
            document: $note,
            detail: $detail,
            sign: $sign,
            formaPago: '-',
            reference: $this->referenceData($note),
        ));
    }

    private function baseRow($document, $detail, int $sign, string $formaPago, array $reference = []): array
    {
        $fechaEmision = Carbon::parse($document->fechaEmision, 'America/Lima');
        $fechaProceso = $document->created_at
            ? Carbon::parse($document->created_at, 'America/Lima')
            : $fechaEmision;
        $tipoAfectacion = (string) ($detail->tipAfeIgv ?? '10');
        $valorVenta = round((float) ($detail->mtoValorVenta ?? $detail->mtoBaseIgv ?? 0) * $sign, 2);
        $igv = round((float) ($detail->igv ?? 0) * $sign, 2);
        $importeTotal = round(((float) ($detail->mtoPrecioUnitario ?? 0) * (float) ($detail->cantidad ?? 0)) * $sign, 2);

        if ($importeTotal === 0.0) {
            $importeTotal = round($valorVenta + $igv, 2);
        }

        return [
            'document_key' => $document::class.':'.$document->id,
            'numero_correlativo' => 0,
            'fecha_emision' => $fechaEmision->format('d/m/Y'),
            'fecha_emision_raw' => $fechaEmision->format('Y-m-d H:i:s'),
            'fecha_vencimiento' => '',
            'tipo_doc' => $document->tipoDoc,
            'tipo_doc_tabla' => $this->sunatNumericCode($document->tipoDoc),
            'serie' => $document->serie,
            'numero' => $document->correlativo,
            'cliente_tipo_doc' => $document->client?->type_code,
            'cliente_numero' => $document->client?->code,
            'cliente_nombre' => $document->estado === 'ANULADO' ? 'ANULADA' : $document->client?->name,
            'articulo' => $document->estado === 'ANULADO' ? '' : (string) ($detail->descripcion ?? ''),
            'cantidad' => $document->estado === 'ANULADO' ? 0 : (float) ($detail->cantidad ?? 0),
            'exportacion' => $tipoAfectacion === '40' ? $valorVenta : 0,
            'base_gravada' => $tipoAfectacion === '10' ? $valorVenta : 0,
            'exonerada' => $tipoAfectacion === '20' ? $valorVenta : 0,
            'inafecta' => $tipoAfectacion === '30' ? $valorVenta : 0,
            'isc' => 0,
            'igv' => in_array($tipoAfectacion, ['10', '20', '30', '40'], true) ? $igv : 0,
            'otros_tributos' => 0,
            'importe_total' => $document->estado === 'ANULADO' ? 0 : $importeTotal,
            'tipo_cambio' => '1.000',
            'ref_fecha' => $reference['fecha'] ?? '',
            'ref_tipo' => $reference['tipo'] ?? '',
            'ref_serie' => $reference['serie'] ?? '',
            'ref_numero' => $reference['numero'] ?? '',
            'fecha_proceso' => $fechaProceso->format('d/m/Y'),
            'codigo_estado_sunat' => $document->cdr_code ?? '',
            'descripcion_estado_sunat' => $this->estadoSunat($document),
            'forma_pago' => $formaPago,
        ];
    }

    private function referenceData(Note $note): array
    {
        $parts = explode('-', (string) $note->numDocfectado, 2);

        return [
            'fecha' => '',
            'tipo' => $this->sunatNumericCode($note->tipoDocAfectado),
            'serie' => $parts[0] ?? '',
            'numero' => $parts[1] ?? '',
        ];
    }

    private function estadoSunat($document): string
    {
        if (! empty($document->cdr_description)) {
            return $document->cdr_description;
        }

        if (! empty($document->errorMessage)) {
            return $document->errorMessage;
        }

        if (($document->estado ?? null) === 'ANULADO') {
            return 'Anulado';
        }

        if (($document->cdr_code ?? null) === '0') {
            return 'Aceptado';
        }

        return empty($document->cdr_code) ? 'Pendiente' : 'Observado';
    }

    private function sunatNumericCode(?string $code): string
    {
        $numeric = ltrim((string) $code, '0');

        return $numeric === '' ? (string) $code : $numeric;
    }

    private function periodRange(): array
    {
        $month = preg_match('/^\d{4}-\d{2}$/', $this->filtroMes)
            ? $this->filtroMes
            : now('America/Lima')->format('Y-m');

        $start = Carbon::createFromFormat('Y-m-d H:i:s', $month.'-01 00:00:00', 'America/Lima')->startOfMonth();

        return [$start, $start->copy()->endOfMonth()];
    }

    private function canViewAllSucursales(): bool
    {
        $user = Auth::user();

        return $user?->hasRole(['SuperAdmin', 'Administrador']) ?? false;
    }

    private function getSucursales(): Collection
    {
        return Sucursal::where('isActive', true)->get();
    }

    private function getOrigenes(): array
    {
        return [
            ['id' => 'todos', 'name' => 'Invoices y notes'],
            ['id' => 'invoices', 'name' => 'Solo invoices'],
            ['id' => 'notes', 'name' => 'Solo notes'],
        ];
    }
}
