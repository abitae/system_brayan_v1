<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Livewire\Forms\ExitCajaForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Traits\CajaTrait;
use App\Traits\InvoiceTrait;
use App\Traits\LogCustom;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReturnPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination, InvoiceTrait;
    use CajaTrait, UtilsTrait;
    use InvoiceTrait;
    public EntryCajaForm $entryForm;
    public ExitCajaForm $exitForm;
    public CustomerForm $customerFact;
    public $title = 'ENTREGA PAQUETES CON RETORNO';
    public $sub_title = 'Modulo de entrega de paquetes con retorno';
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
    public $estado_pago;//PAGADO, CONTRA ENTREGA
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
        $this->filtroFechaInicio = Carbon::now()->startOfDay()->format('Y-m-d H:i');//$this->dateNow('Y-m-d');
        $this->filtroFechaFin = $this->dateNow('Y-m-d H:i:s');
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
            ->where('isHome', true)
            ->where('isReturn', true);
        // Apply date range filter if both dates are set
        if ($this->filtroFechaInicio && $this->filtroFechaFin) {
            $encomiendas->whereBetween('created_at', [
                Carbon::parse($this->filtroFechaInicio)->startOfDay(),
                Carbon::parse($this->filtroFechaFin)->endOfDay()
            ]);
        }
        // Apply search filter across multiple related fields
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
        return view('livewire.package.return-package-live', compact('encomiendas', 'sucursals', 'pagos', 'comprobantes', 'tipoDocuments'));
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
        if ($this->encomienda->destinatario->code == $this->document) {
            $this->customerFact->setCustomer($this->encomienda->destinatario);
            $this->estado_pago = $this->encomienda->estado_pago;
            $this->modalDeliver = false;
            $this->modalConfimation = true;
        } else {
            $this->error('Error', 'Datos incorrectos');
        }
    }

    /**
     * Process package return to home delivery
     */
    private function processReturn(bool $isHome): void
    {
        // Check if destination branch configuration exists
        $hasDestination = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->exists();

        if (!$hasDestination) {
            redirect()->route('config.configuration');
            return;
        }

        // Update package status and location
        $this->encomienda->update([
            'sucursal_dest_id' => $this->encomienda->sucursal_id,
            'sucursal_id' => Auth::user()->sucursal->id,
            'fecha_retorno' => Carbon::now(),
            'estado_encomienda' => 'RETORNADO',
            'isHome' => $isHome,
            'created_at' => Carbon::now(),
            'isReturn' => false
        ]);

        // Update modal states
        $this->modalConfimation = false;
        $this->modalFinal = true;
    }

    /**
     * Handle return for home delivery
     */
    public function retornoHome()
    {
        $this->processReturn(true);
    }

    /**
     * Handle return to agency
     */
    public function retornoAgencia()
    {
        $this->processReturn(false);
    }

}
