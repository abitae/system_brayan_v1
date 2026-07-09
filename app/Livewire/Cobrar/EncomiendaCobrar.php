<?php

namespace App\Livewire\Cobrar;

use App\Exports\ReportEncomiendaExport;
use App\Models\Caja\Caja;
use App\Models\Caja\EntryCaja;
use App\Models\Caja\ExitCaja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Traits\CajaTrait;
use App\Traits\InvoiceTrait;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class EncomiendaCobrar extends Component
{
    use Toast, UtilsTrait, WithPagination, WithoutUrlPagination;
    use CajaTrait, SearchDocument;
    use InvoiceTrait, LogCustom;

    const DEFAULT_PER_PAGE = 10;

    const ESTADOS_ENCOMIENDA = [
        ['id' => 'REGISTRADO', 'name' => 'REGISTRADO'],
        ['id' => 'ENVIADO', 'name' => 'ENVIADO'],
        ['id' => 'RECIBIDO', 'name' => 'RECIBIDO'],
        ['id' => 'ENTREGADO', 'name' => 'ENTREGADO'],
    ];

    const ESTADOS_CREDITO = [
        ['id' => 'Pendiente', 'name' => 'PENDIENTE'],
        ['id' => 'Cancelado', 'name' => 'CANCELADO'],
    ];

    const METODOS_PAGO = [
        ['id' => 'Efectivo', 'name' => 'Efectivo'],
        ['id' => 'Yape', 'name' => 'Yape'],
        ['id' => 'Transferencia', 'name' => 'Transferencia'],
        ['id' => 'Tarjeta', 'name' => 'Tarjeta'],
        ['id' => 'Deposito', 'name' => 'Deposito'],
    ];

    public string $title = 'CUENTAS POR COBRAR';

    public string $sub_title = 'Cobro de encomiendas registradas a crédito';

    public bool $cobroCredito = true;

    public ?int $filtroSucursal = null;

    public ?string $filtroFechaInicio = null;

    public ?string $filtroFechaFin = null;

    public ?string $search = null;

    public ?string $FiltroEstadoEncomienda = null;

    public ?string $FiltroEstadoCredito = 'Pendiente';

    public ?string $filtroMetodoPago = null;

    public int $perPage = self::DEFAULT_PER_PAGE;

    public bool $showDrawer = false;

    public array $ids = [];

    public Encomienda $encomienda;

    public $cliFacturacion;

    public $cliFacturacion_type_code = '1';

    public $cliFacturacion_code;

    public $cliFacturacion_name;

    public $cliFacturacion_address;

    public $cliFacturacion_phone;

    public $cliFacturacion_ubigeo;

    public $monto_descuento;

    public $motivo_descuento;

    public string $tipo_pago = 'Contado';

    public string $tipo_comprobante = 'TICKET';

    public string $metodo_pago = 'Efectivo';

    public bool $modalCobrar = false;

    public function mount(): void
    {
        $this->resetFilters();

        if (! $this->cajaIsActive(Auth::user())) {
            $this->warning('Debe abrir caja antes de cobrar encomiendas');
            $this->redirectRoute('caja.index');
        }
    }

    public function resetFilters(): void
    {
        $this->filtroFechaInicio = $this->filterDateStart();
        $this->filtroFechaFin = $this->filterDateEnd();
        $this->FiltroEstadoEncomienda = null;
        $this->FiltroEstadoCredito = 'Pendiente';
        $this->filtroMetodoPago = null;
        $this->filtroSucursal = null;
        $this->search = null;
    }

    public function render()
    {
        $encomiendas = $this->getEncomiendasQuery();
        $this->ids = $encomiendas->pluck('id')->toArray();

        return view('livewire.cobrar.encomienda-cobrar', [
            'encomiendas' => $encomiendas->latest()->paginate($this->perPage),
            'sucursals' => $this->getSucursales(),
            'estados' => self::ESTADOS_ENCOMIENDA,
            'estadosCredito' => self::ESTADOS_CREDITO,
            'metodosPago' => self::METODOS_PAGO,
            'totalRegistros' => $encomiendas->count(),
        ]);
    }

    private function getEncomiendasQuery(): Builder
    {
        $query = Encomienda::query()
            ->where('tipo_pago', 'Credito')
            ->where('isActive', true)
            ->with(['remitente', 'destinatario', 'invoice', 'ticket', 'despatche']);

        if ($this->filtroSucursal) {
            $query->where('sucursal_id', $this->filtroSucursal);
        }

        if ($this->filtroFechaInicio && $this->filtroFechaFin) {
            $query->whereBetween('created_at', [
                $this->parseFilterDateStart($this->filtroFechaInicio),
                $this->parseFilterDateEnd($this->filtroFechaFin),
            ]);
        }

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

        if ($this->FiltroEstadoEncomienda) {
            $query->where('estado_encomienda', $this->FiltroEstadoEncomienda);
        }

        if ($this->FiltroEstadoCredito) {
            $query->where('estado_credito', $this->FiltroEstadoCredito);
        }

        if ($this->filtroMetodoPago) {
            $query->where('metodo_pago', $this->filtroMetodoPago);
        }

        return $query;
    }

    private function getSucursales()
    {
        return Sucursal::where('isActive', true)->get();
    }

    public function showEncomienda(Encomienda $encomienda): void
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    public function createBoleta(Encomienda $encomienda)
    {
        return $this->redirectRoute(
            'facturacion.create-invoice',
            ['id' => $encomienda->id],
            false,
            false
        );
    }

    public function excelGenerate()
    {
        if (empty($this->ids)) {
            $this->warning('No hay datos para exportar');

            return null;
        }

        $filename = 'reporte_cuentas_por_cobrar_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        $this->success('Reporte generado con éxito');

        return Excel::download(new ReportEncomiendaExport($this->ids), $filename);
    }

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

    public function updated($property): void
    {
        if (in_array($property, [
            'filtroSucursal',
            'filtroFechaInicio',
            'filtroFechaFin',
            'FiltroEstadoEncomienda',
            'FiltroEstadoCredito',
            'filtroMetodoPago',
            'search',
        ], true)) {
            $this->resetPage();
        }
    }

    public function modalCobrarOpen(Encomienda $encomienda): void
    {
        $encomienda->load(['remitente', 'destinatario', 'facturacion', 'ticket', 'invoice']);

        if ($encomienda->tipo_pago !== 'Credito') {
            $this->warning('Esta encomienda no fue registrada a crédito');

            return;
        }

        if ($encomienda->estado_credito !== 'Pendiente') {
            $this->warning('Esta encomienda ya fue cobrada');

            return;
        }

        $this->resetModalCobro();
        $this->encomienda = $encomienda;
        $this->tipo_comprobante = $encomienda->tipo_comprobante ?: 'TICKET';
        $this->tipo_pago = 'Contado';
        $this->metodo_pago = $encomienda->metodo_pago ?: 'Efectivo';

        $facturacion = $encomienda->facturacion ?? $encomienda->remitente;
        $this->cliFacturacion = $facturacion;
        $this->cliFacturacion_type_code = $this->resolveCustomerTypeCode($facturacion);
        $this->cliFacturacion_code = $facturacion->code;
        $this->cliFacturacion_name = $facturacion->name;
        $this->cliFacturacion_address = $facturacion->address;
        $this->cliFacturacion_phone = $facturacion->phone;
        $this->cliFacturacion_ubigeo = $facturacion->ubigeo;
        $this->modalCobrar = true;
    }

    public function cobrarEncomienda(): void
    {
        if ($this->encomienda->tipo_pago !== 'Credito') {
            $this->error('Ops', 'La encomienda no es a crédito');

            return;
        }

        if ($this->encomienda->estado_credito !== 'Pendiente') {
            $this->error('Ops', 'La encomienda ya fue cobrada');

            return;
        }

        $caja = $this->cajaIsActive(Auth::user());
        if (! $caja) {
            $this->error('Ops', 'No tiene una caja abierta');

            return;
        }

        if ($this->tipo_comprobante === 'TICKET') {
            $this->cliFacturacion = $this->encomienda->facturacion ?? $this->encomienda->remitente;
        }

        if ($this->tipo_comprobante === 'FACTURA' && $this->cliFacturacion_type_code != '6') {
            $this->error('Ops', 'El cliente de facturación debe tener RUC');

            return;
        }

        $rules = [
            'tipo_comprobante' => 'required',
            'metodo_pago' => 'required',
        ];

        $messages = [
            'tipo_comprobante.required' => 'El tipo de comprobante es requerido',
            'metodo_pago.required' => 'El método de pago es requerido',
        ];

        if ($this->tipo_comprobante !== 'TICKET') {
            $rules['cliFacturacion'] = 'required';
            $messages['cliFacturacion.required'] = 'El cliente de facturación es requerido';
        }

        if ($this->monto_descuento !== null && $this->monto_descuento !== '') {
            $rules['monto_descuento'] = 'numeric|min:0|lt:' . $this->encomienda->monto;
            $messages['monto_descuento.lt'] = 'El descuento debe ser menor al monto de la encomienda';
        }

        $this->validate($rules, $messages);

        $alreadyPaid = false;

        DB::transaction(function () use ($caja, &$alreadyPaid) {
            $encomienda = Encomienda::whereKey($this->encomienda->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($encomienda->tipo_pago !== 'Credito' || $encomienda->estado_credito !== 'Pendiente') {
                $alreadyPaid = true;
                return;
            }

            $this->encomienda = $encomienda;

            if ($this->hasValidDiscount()) {
                $this->descuentoCreate($caja);
            }

            $this->encomienda->customer_fact_id = $this->cliFacturacion->id;
            $this->encomienda->tipo_comprobante = $this->tipo_comprobante;
            $this->encomienda->tipo_pago = 'Contado';
            $this->encomienda->metodo_pago = $this->metodo_pago;
            $this->encomienda->estado_credito = 'Cancelado';

            if ($this->encomienda->estado_encomienda !== 'ENTREGADO') {
                $this->encomienda->estado_encomienda = 'ENTREGADO';
                $this->encomienda->fecha_entrega = $this->encomienda->fecha_entrega ?? Carbon::now();
            }

            $this->upsertCajaEntry($caja);
            $this->encomienda->save();

            if ($this->encomienda->ticket) {
                $this->encomienda->ticket->formaPago_tipo = 'Contado';
                $this->encomienda->ticket->save();
            }
        });

        if ($alreadyPaid) {
            $this->error('Ops', 'La encomienda ya fue cobrada');
            return;
        }

        if ($this->tipo_comprobante !== 'TICKET') {
            if (! $this->encomienda->invoice) {
                $this->setInvoice($this->encomienda, $this->tipo_comprobante);
            } else {
                $this->encomienda->invoice->formaPago_tipo = 'Contado';
                $this->encomienda->invoice->save();
            }
        }

        $this->infoLog('COBRO CREDITO ' . $this->encomienda->code);
        $this->success('Cobro registrado correctamente');
        $this->modalCobrar = false;
        $this->resetModalCobro();
    }

    private function hasValidDiscount(): bool
    {
        return $this->tipo_comprobante === 'TICKET'
            && is_numeric($this->monto_descuento)
            && (float) $this->monto_descuento > 0
            && (float) $this->monto_descuento < (float) $this->encomienda->monto;
    }

    private function upsertCajaEntry(Caja $caja): void
    {
        EntryCaja::updateOrCreate(
            [
                'caja_id' => $caja->id,
                'description' => 'COBRO CREDITO ' . $this->encomienda->tipo_comprobante,
                'tipo_entry' => $this->encomienda->code,
            ],
            [
                'monto_entry' => $this->encomienda->monto,
                'metodo_pago' => $this->metodo_pago,
            ]
        );
    }

    private function descuentoCreate(Caja $caja): void
    {
        $this->encomienda->monto_descuento = $this->monto_descuento;
        $this->encomienda->motivo_descuento = $this->motivo_descuento;
        $this->encomienda->save();

        if ($this->encomienda->ticket) {
            $this->encomienda->ticket->monto_descuento = $this->monto_descuento;
            $this->encomienda->ticket->motivo_descuento = $this->motivo_descuento;
            $this->encomienda->ticket->save();
        }

        $description = 'DESCUENTO ' . $this->tipo_comprobante;
        $exit = ExitCaja::where('caja_id', $caja->id)
            ->where('tipo_exit', $this->encomienda->code)
            ->where('description', $description)
            ->first();

        if ($exit) {
            $exit->update([
                'monto_exit' => $this->monto_descuento,
                'metodo_pago' => $this->metodo_pago,
            ]);

            return;
        }

        $this->cajaExit(
            $caja->id,
            (float) $this->monto_descuento,
            $description,
            $this->metodo_pago,
            $this->encomienda->code
        );
    }

    private function resetModalCobro(): void
    {
        $this->monto_descuento = null;
        $this->motivo_descuento = null;
        $this->tipo_pago = 'Contado';
        $this->tipo_comprobante = 'TICKET';
        $this->metodo_pago = 'Efectivo';
        $this->cliFacturacion = null;
        $this->cliFacturacion_type_code = '1';
        $this->cliFacturacion_code = null;
        $this->cliFacturacion_name = null;
        $this->cliFacturacion_address = null;
        $this->cliFacturacion_phone = null;
        $this->cliFacturacion_ubigeo = null;
    }

    private function resolveCustomerTypeCode(Customer $customer): string
    {
        return in_array((string) $customer->type_code, ['6', 'ruc', 'RUC'], true) ? '6' : '1';
    }

    public function searchFacturacion(): void
    {
        $rules = [
            'cliFacturacion_type_code' => 'required',
            'cliFacturacion_code' => 'required|min:8|max:11',
        ];
        $messages = [
            'cliFacturacion_type_code.required' => 'El tipo de documento es requerido',
            'cliFacturacion_code.required' => 'El número de documento es requerido',
            'cliFacturacion_code.min' => 'El número de documento debe tener al menos 8 dígitos',
            'cliFacturacion_code.max' => 'El número de documento debe tener máximo 11 dígitos',
        ];
        $this->validate($rules, $messages);

        $cliFacturacion = Customer::where('type_code', $this->cliFacturacion_type_code)
            ->where('code', $this->cliFacturacion_code)
            ->first();

        if ($cliFacturacion) {
            $this->cliFacturacion = $cliFacturacion;
            $this->cliFacturacion_name = $cliFacturacion->name;
            $this->cliFacturacion_address = $cliFacturacion->address;
            $this->cliFacturacion_phone = $cliFacturacion->phone;
            $this->cliFacturacion_ubigeo = $cliFacturacion->ubigeo;

            return;
        }

        $tipo = $this->cliFacturacion_type_code == '6' ? 'ruc' : 'dni';
        $respuesta = $this->searchComplete($tipo, $this->cliFacturacion_code);

        if (! $respuesta['encontrado']) {
            $this->cliFacturacion = null;
            $this->cliFacturacion_name = '';
            $this->cliFacturacion_address = '';
            $this->cliFacturacion_phone = '';
            $this->cliFacturacion_ubigeo = '';
            $this->error('El cliente de facturación no existe, verifique el número de documento');

            return;
        }

        if ($tipo == 'ruc') {
            $this->cliFacturacion_name = $respuesta['data']->razon_social;
            $this->cliFacturacion_address = $respuesta['data']->direccion;
            $this->cliFacturacion_ubigeo = $respuesta['data']->codigo_ubigeo;
        } else {
            $this->cliFacturacion_name = $respuesta['data']->nombre;
            $this->cliFacturacion_phone = '';
            $this->cliFacturacion_ubigeo = '';
        }

        $this->cliFacturacion = Customer::firstOrCreate(
            [
                'type_code' => $this->cliFacturacion_type_code,
                'code' => $this->cliFacturacion_code,
            ],
            [
                'name' => $this->cliFacturacion_name,
                'address' => $this->cliFacturacion_address,
                'ubigeo' => $this->cliFacturacion_ubigeo,
            ]
        );
    }
}
