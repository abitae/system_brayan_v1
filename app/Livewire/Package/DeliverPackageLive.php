<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Livewire\Forms\ExitCajaForm;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class DeliverPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination, InvoiceTrait;
    use CajaTrait, UtilsTrait, SearchDocument;
    use InvoiceTrait;
    public EntryCajaForm $entryForm;
    public ExitCajaForm $exitForm;
    public CustomerForm $customerFact;
    public $title = 'ENTREGA PAQUETES AGENCIA';
    public $sub_title = 'Modulo de entrega de paquetes en agencia';
    public $search = '';
    public $perPage = 100;
    public $filtroFechaInicio;
    public int $sucursal_id;
    public $filtroFechaFin;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalDeliver = false;
    public $encomienda;
    public $document;
    public $pin;
    public $showDrawer;
    public $estado_pago; //PAGADO, CONTRA ENTREGA
    public $tipo_pago = 'Contado';
    public $tipo_comprobante = 'TICKET';
    public $metodo_pago = 'Efectivo';
    public $caja;
    public bool $modalConfimation;
    public bool $modalDescuento;
    public $monto_descuento;
    public $motivo_descuento;
    public $modalFinal;
    public $modalCobrar = false;
    public $cliFacturacion;
    public $cliFacturacion_type_code = 1;
    public $cliFacturacion_code;
    public $cliFacturacion_name;
    public $cliFacturacion_address;
    public $cliFacturacion_phone;
    public $cliFacturacion_ubigeo;

    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (!$this->caja) {
            $this->redirectRoute('caja.index');
        }
        $this->sucursal_id = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->first()->id;
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
        $sucursals = Sucursal::where('isActive', true)
            ->whereNot('id', [Auth::user()->sucursal->id])
            ->get();
        $encomiendas = Encomienda::query()
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where('isHome', false);
        // Apply date range filter if both dates are set
        if ($this->filtroFechaInicio && $this->filtroFechaFin) {
            $encomiendas->whereBetween('fecha_recepcion', [
                $this->parseFilterDateStart($this->filtroFechaInicio),
                $this->parseFilterDateEnd($this->filtroFechaFin),
            ]);
        }
        if (!empty($this->search)) {
            $searchTerm = '%' . trim($this->search) . '%';

            $encomiendas->where(function ($query) use ($searchTerm) {
                $query->where('code', 'like', $searchTerm)
                    ->orWhereHas('destinatario', function ($q) use ($searchTerm) {
                        $q->where('code', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('remitente', function ($q) use ($searchTerm) {
                        $q->where('code', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    });
            });
        }
        $encomiendas = $encomiendas->latest()
            ->paginate($this->perPage, '*', 'page');

        $pagos = [
            ['id' => 'PAGADO', 'name' => 'PAGADO'],
            ['id' => 'CONTRA ENTREGA', 'name' => 'CONTRA ENTREGA'],
        ];
        $comprobantes = [
            ['id' => 'BOLETA', 'name' => 'BOLETA'],
            ['id' => 'FACTURA', 'name' => 'FACTURA'],
            ['id' => 'TICKET', 'name' => 'TICKET'],
        ];
        $tipoDocuments = [
            ['codigo' => '0', 'sigla' => 'OTRO DOCUMENTO cod(0)'],
            ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
            ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
        ];
        return view('livewire.package.deliver-package-live', compact('encomiendas', 'sucursals', 'pagos', 'comprobantes', 'tipoDocuments'));
    }

    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    public function openModal(Encomienda $encomienda)
    {
        $this->document = $encomienda->destinatario->code;
        $this->pin = '';
        $this->modalDeliver = !$this->modalDeliver;
        $this->encomienda = $encomienda;
    }

    public function deliverPaquetes()
    {
        if ($this->encomienda->isHome) {
            $this->pin = 123;
        }
        if ($this->encomienda->destinatario->code == $this->document && $this->encomienda->pin == $this->pin) {
            $this->customerFact->setCustomer($this->encomienda->destinatario);
            $this->estado_pago = $this->encomienda->estado_pago;
            $this->modalDeliver = false;
            $this->modalConfimation = true;
        } else {
            $this->error('Error', 'Datos incorrectos');
        }
    }

    public function confirmEncomienda()
    {
        if ($this->encomienda->estado_pago == 'PAGADO') {
            $this->encomienda->fecha_entrega = Carbon::now();
            $this->encomienda->estado_encomienda = 'ENTREGADO';
            $this->encomienda->estado_credito = 'Cancelado';
            $this->encomienda->save();
        }
        $this->modalConfimation = false;
        $this->modalFinal = true;
    }
    public function modalCobrarOpen()
    {
        $this->cliFacturacion = $this->encomienda->facturacion;
        $this->cliFacturacion_type_code = $this->encomienda->facturacion->type_code == 'dni' ? 1 : 6;
        $this->cliFacturacion_code = $this->encomienda->facturacion->code;
        $this->cliFacturacion_name = $this->encomienda->facturacion->name;
        $this->cliFacturacion_address = $this->encomienda->facturacion->address;
        $this->cliFacturacion_phone = $this->encomienda->facturacion->phone;
        $this->cliFacturacion_ubigeo = $this->encomienda->facturacion->ubigeo;
        $this->modalConfimation = false;
        $this->modalCobrar = true;
    }
    public function searchFacturacion()
    {

        $rules = [
            'cliFacturacion_type_code' => 'required',
            'cliFacturacion_code' => 'required|min:8|max:11',
        ];
        $messages = [
            'cliFacturacion_type_code.required' => 'El tipo de documento es requerido',
            'cliFacturacion_code.required' => 'El número de documento es requerido',
            'cliFacturacion_code.min' => 'El número de documento debe tener 8 dígitos',
            'cliFacturacion_code.max' => 'El número de documento debe tener 11 dígitos',
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
        if (!$respuesta['encontrado']) {
            $this->cliFacturacion = null;
            $this->cliFacturacion_name = '';
            $this->cliFacturacion_address = '';
            $this->cliFacturacion_phone = '';
            $this->cliFacturacion_ubigeo = '';
            $this->error('El cliente de Facturacion no existe!, verifique el número de documento!');
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
                'code' => $this->cliFacturacion_code
            ],
            [
                'name' => $this->cliFacturacion_name,
                'address' => $this->cliFacturacion_address,
                'ubigeo' => $this->cliFacturacion_ubigeo
            ]
        );
    }
    public function cobrarEncomienda()
    {
        if ($this->tipo_comprobante == 'TICKET') {
            $this->cliFacturacion = $this->encomienda->facturacion;
        }
        if ($this->tipo_comprobante == 'FACTURA' && $this->cliFacturacion_type_code != '6') {
            $this->error('Ops', 'El cliente de Facturacion debe ser un RUC!');
            return;
        }
        $rules = [
            'cliFacturacion' => 'required',
            'tipo_comprobante' => 'required',
            'tipo_pago' => 'required',
            'metodo_pago' => 'required',
        ];
        $message = [
            'cliFacturacion.required' => 'El cliente de facturacion es requerido',
            'tipo_comprobante.required' => 'El tipo de comprobante es requerido',
            'tipo_pago.required' => 'El tipo de pago es requerido',
            'metodo_pago.required' => 'El método de pago es requerido',
        ];
        if ($this->monto_descuento !== null && $this->monto_descuento !== '') {
            $rules['monto_descuento'] = 'numeric|min:0|lt:' . $this->encomienda->monto;
            $message['monto_descuento.lt'] = 'El descuento debe ser menor al monto de la encomienda';
        }

        $this->validate($rules, $message);

        $caja = $this->cajaIsActive(Auth::user());
        if (! $caja) {
            $this->error('Ops', 'No tiene una caja abierta');
            return;
        }

        $alreadyDelivered = false;

        DB::transaction(function () use ($caja, &$alreadyDelivered) {
            $encomienda = Encomienda::whereKey($this->encomienda->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($encomienda->estado_encomienda !== 'RECIBIDO') {
                $alreadyDelivered = true;
                return;
            }

            $this->encomienda = $encomienda;

            if ($this->hasValidDiscount()) {
                $this->descuentoCreate($caja);
            }

            $this->encomienda->customer_fact_id = $this->cliFacturacion->id;
            $this->encomienda->tipo_comprobante = $this->tipo_comprobante;
            $this->encomienda->tipo_pago = $this->tipo_pago;
            $this->encomienda->metodo_pago = $this->metodo_pago;
            $this->encomienda->estado_encomienda = 'ENTREGADO';
            $this->encomienda->fecha_entrega = Carbon::now();

            if ($this->tipo_pago == 'Contado') {
                $this->upsertCajaEntry($caja);
                $this->encomienda->estado_credito = 'Cancelado';
            } else {
                $this->encomienda->estado_credito = 'Pendiente';
            }

            $this->encomienda->save();
        });

        if ($alreadyDelivered) {
            $this->error('Ops', 'La encomienda ya fue entregada o no esta disponible para entrega');
            return;
        }

        if ($this->tipo_comprobante != 'TICKET') {
            $this->setInvoice($this->encomienda, $this->tipo_comprobante);
        }
        $this->modalCobrar = false;
        $this->modalFinal = true;
    }
    private function hasValidDiscount(): bool
    {
        return $this->tipo_comprobante == 'TICKET'
            && is_numeric($this->monto_descuento)
            && (float) $this->monto_descuento > 0
            && (float) $this->monto_descuento < (float) $this->encomienda->monto;
    }

    private function upsertCajaEntry(Caja $caja): void
    {
        EntryCaja::updateOrCreate(
            [
                'caja_id' => $caja->id,
                'description' => 'ENTREGA ' . $this->encomienda->tipo_comprobante,
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
            ->whereIn('description', [$description, ' ' . $description])
            ->first();

        if ($exit) {
            $exit->update([
                'monto_exit' => $this->monto_descuento,
                'description' => $description,
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
}
