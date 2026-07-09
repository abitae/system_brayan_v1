<?php

namespace App\Livewire\Report;

use App\Exports\ReportEncomiendaExport;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class EncomiendasReport extends Component
{
    use Toast, UtilsTrait, WithPagination, WithoutUrlPagination;

    // Constantes para valores predeterminados y opciones
    const DEFAULT_PER_PAGE = 10;
    const ESTADOS_ENCOMIENDA = [
        ['id' => 'REGISTRADO', 'name' => 'REGISTRADO'],
        ['id' => 'ENVIADO', 'name' => 'ENVIADO'],
        ['id' => 'RECIBIDO', 'name' => 'RECIBIDO'],
        ['id' => 'ENTREGADO', 'name' => 'ENTREGADO']
    ];
    const ESTADOS_PAGO = [
        ['id' => 'Contado', 'name' => 'Contado'],
        ['id' => 'Credito', 'name' => 'Credito'],
    ];
    const METODOS_PAGO = [
        ['id' => 'Efectivo', 'name' => 'Efectivo'],
        ['id' => 'Transferencia', 'name' => 'Transferencia'],
        ['id' => 'Tarjeta', 'name' => 'Tarjeta'],
    ];
    const TIPOS_COMPROBANTE = [
        ['id' => 'TICKET', 'name' => 'Ticket'],
        ['id' => 'BOLETA', 'name' => 'Boleta'],
        ['id' => 'FACTURA', 'name' => 'Factura'],
    ];

    // Propiedades principales
    public string $title = 'REPORTE ENCOMIENDAS';
    public string $sub_title = 'Módulo de reporte de encomiendas detallado';

    // Propiedades para filtros
    public ?int $filtroSucursal = null;
    public ?string $filtroFechaInicio = null;
    public ?string $filtroFechaFin = null;
    public ?string $search = null;
    public ?string $FiltroEstadoEncomienda = null;
    public ?string $FiltroEstadoPago = null;
    public ?string $filtroMetodoPago = null;
    public ?string $filtroTipoComprobante = null;
    public int $perPage = self::DEFAULT_PER_PAGE;

    public bool $soloSucursalUsuario = false;

    // Propiedades para la interfaz
    public bool $showDrawer = false;
    public array $ids = [];
    public Encomienda $encomienda;

    /**
     * Hook que se ejecuta al inicializar el componente
     *
     * @return void
     */
    public function mount(): void
    {
        $this->resetFilters();

        $user = Auth::user();
        if ($user && ! $this->canViewAllSucursales()) {
            $this->filtroSucursal = $user->sucursal_id;
            $this->soloSucursalUsuario = true;
        }
    }

    /**
     * Reinicia los filtros a sus valores predeterminados
     *
     * @return void
     */
    public function resetFilters(): void
    {
        $this->filtroFechaInicio = $this->filterDateStart();
        $this->filtroFechaFin = $this->filterDateEnd();
        $this->FiltroEstadoEncomienda = null;
        $this->FiltroEstadoPago = null;
        $this->filtroMetodoPago = null;
        $this->filtroTipoComprobante = null;
        $this->search = null;

        if (! $this->soloSucursalUsuario) {
            $this->filtroSucursal = null;
        }
    }

    /**
     * Método principal de renderizado del componente
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $encomiendas = $this->getEncomiendasQuery();
        $this->ids = $encomiendas->pluck('id')->toArray();

        return view('livewire.report.encomiendas-report', [
            'encomiendas' => $encomiendas->latest()->paginate($this->perPage),
            'sucursals' => $this->getSucursales(),
            'estados' => self::ESTADOS_ENCOMIENDA,
            'estadosPago' => self::ESTADOS_PAGO,
            'metodosPago' => self::METODOS_PAGO,
            'tiposComprobante' => self::TIPOS_COMPROBANTE,
            'totalRegistros' => $encomiendas->count(),
            'soloSucursalUsuario' => $this->soloSucursalUsuario,
        ]);
    }

    private function canViewAllSucursales(): bool
    {
        $user = Auth::user();

        return $user?->hasRole(['SuperAdmin', 'Administrador']) ?? false;
    }

    /**
     * Obtiene la consulta base de encomiendas con filtros aplicados
     *
     * @return Builder
     */
    private function getEncomiendasQuery(): Builder
    {
        $query = Encomienda::query();

        // Aplicar filtro por sucursal
        if ($this->filtroSucursal) {
            $query->where('sucursal_id', $this->filtroSucursal);
        }

        // Aplicar filtro por rango de fechas
        if ($this->filtroFechaInicio && $this->filtroFechaFin) {
            $query->whereBetween('created_at', [
                $this->parseFilterDateStart($this->filtroFechaInicio),
                $this->parseFilterDateEnd($this->filtroFechaFin),
            ]);
        }

        // Aplicar búsqueda global
        if ($this->search) {
            $query->where(function (Builder $query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('remitente', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('code', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('destinatario', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('code', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Aplicar filtro por estado de encomienda
        if ($this->FiltroEstadoEncomienda) {
            $query->where('estado_encomienda', $this->FiltroEstadoEncomienda);
        }

        // Aplicar filtro por estado de pago
        if ($this->FiltroEstadoPago) {
            $query->where('tipo_pago', $this->FiltroEstadoPago);
        }

        // Aplicar filtro por método de pago
        if ($this->filtroMetodoPago) {
            $query->where('metodo_pago', $this->filtroMetodoPago);
        }

        // Aplicar filtro por tipo de comprobante emitido
        if ($this->filtroTipoComprobante) {
            $query->where('tipo_comprobante', $this->filtroTipoComprobante);
        }

        return $query;
    }

    /**
     * Obtiene las sucursales activas
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getSucursales()
    {
        return Sucursal::where('isActive', true)->get();
    }

    /**
     * Muestra el detalle de una encomienda
     *
     * @param Encomienda $encomienda
     * @return void
     */
    public function showEncomienda(Encomienda $encomienda): void
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    /**
     * Redirige a la creación de boleta/factura
     *
     * @param Encomienda $encomienda
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createBoleta(Encomienda $encomienda)
    {
        return $this->redirectRoute(
            'facturacion.create-invoice',
            ['id' => $encomienda->id],
            false,
            false
        );
    }

    /**
     * Genera y descarga el reporte en Excel
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excelGenerate()
    {
        if (empty($this->ids)) {
            $this->warning('No hay datos para exportar');
            return null;
        }

        $filename = 'reporte_encomiendas_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        $this->success('Reporte generado con éxito');

        return Excel::download(new ReportEncomiendaExport($this->ids), $filename);
    }

    /**
     * Actualiza la cantidad de registros por página
     *
     * @param int $value
     * @return void
     */
    public function updatedPerPage($value): void
    {
        $this->resetPage();
    }

    public function updatedFiltroFechaInicio(): void
    {
        $this->ensureDateRangeOrder($this->filtroFechaInicio, $this->filtroFechaFin);
    }

    public function updatedFiltroFechaFin(): void
    {
        $this->ensureDateRangeOrder($this->filtroFechaInicio, $this->filtroFechaFin);
    }

    /**
     * Actualiza cualquier filtro y reinicia la paginación
     *
     * @param mixed $value
     * @param string $property
     * @return void
     */
    public function updated($property): void
    {
        if (in_array($property, [
            'filtroSucursal',
            'filtroFechaInicio',
            'filtroFechaFin',
            'FiltroEstadoEncomienda',
            'FiltroEstadoPago',
            'filtroMetodoPago',
            'filtroTipoComprobante',
            'search'
        ])) {
            $this->resetPage();
        }
    }
}
