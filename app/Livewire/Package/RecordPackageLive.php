<?php

namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Livewire\Forms\CustomerForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use App\Traits\UtilsTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class RecordPackageLive extends Component
{
    use LogCustom;
    use Toast, UtilsTrait;
    use WithPagination, WithoutUrlPagination;
    public $title = 'ENCOMIENDAS ENTREGADAS';
    public $sub_title = 'Modulo de paquetes entregados';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id;
    public $date_ini;
    public $date_fin;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $caja;
    public $editModal = false;
    public $isHome = false;
    public CustomerForm $customerFormDest;
    public function mount()
    {
        $this->sucursal_dest_id = Sucursal::where('isActive', true)->first()->id;
        $this->date_ini = Carbon::now()->startOfDay()->format('Y-m-d H:i');
        $this->date_fin = $this->dateNow('Y-m-d H:i:s');
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->get();
        $encomiendas = Encomienda::query()
            ->when($this->date_ini && $this->date_fin, function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->date_ini)->startOfDay(),
                    Carbon::parse($this->date_fin)->endOfDay()
                ]);
            })
            ->where([
                'isActive' => $this->isActive,
                'sucursal_id' => $this->sucursal_dest_id,
                'estado_encomienda' => 'ENTREGADO'
            ])
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('remitente', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    })
                        ->orWhere('code', 'like', $searchTerm)
                        ->orWhereHas('destinatario', function ($subQuery) use ($searchTerm) {
                            $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                        });
                });
            })
            ->latest()
            ->paginate($this->perPage, ['*'], 'page');
        return view('livewire.package.record-package-live', compact('encomiendas', 'sucursals'));
    }


    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }
}
