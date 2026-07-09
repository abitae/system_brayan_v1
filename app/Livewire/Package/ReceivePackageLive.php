<?php

namespace App\Livewire\Package;

use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReceivePackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    use UtilsTrait;

    public $title = 'RECIBIR PAQUETES';
    public $sub_title = 'Modulo de recepcion de paquetes';
    public $perPage = 100;
    public array $selected = [];
    public $search;
    public $date_ini;
    public $date_fin;
    public int $sucursal_id;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalEnvio = false;
    public bool $showDrawer = false;
    public Encomienda $encomienda;

    public function mount()
    {
        $this->sucursal_id = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->first()->id;
        $this->date_ini = $this->filterDateStart();
        $this->date_fin = $this->filterDateEnd();
    }

    public function updatedDateIni(): void
    {
        $this->ensureDateRangeOrder($this->date_ini, $this->date_fin);
    }

    public function updatedDateFin(): void
    {
        $this->ensureDateRangeOrder($this->date_ini, $this->date_fin);
    }

    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->get();
            $encomiendas = Encomienda::query()
            ->when($this->date_ini && $this->date_fin, function($query) {
                $query->whereBetween('fecha_envio', [
                    $this->parseFilterDateStart($this->date_ini),
                    $this->parseFilterDateEnd($this->date_fin),
                ]);
            })
            ->where([
                'sucursal_id' => $this->sucursal_id,
                'sucursal_dest_id' => Auth::user()->sucursal->id,
                'estado_encomienda' => 'ENVIADO'
            ])
            // Search in related models and package code
            ->when($this->search, function($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('remitente', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    })
                    ->orWhere('code', 'like', $searchTerm)
                    ->orWhereHas('destinatario', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    });
                });
            })
            ->latest()
            ->paginate($this->perPage, ['*'], 'page');

        return view('livewire.package.receive-package-live', compact('encomiendas', 'sucursals'));
    }

    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_rem = Sucursal::findOrFail($this->sucursal_id);
            $this->toggleModalEnvio();
        } else {
            $this->error('Seleccione al menos un paquete!');
        }
    }

    public function receivePaquetes()
    {
        $retorno = Encomienda::whereIn('id', $this->selected)->update([
            'estado_encomienda' => 'RECIBIDO',
            'fecha_recepcion' => Carbon::now(),
            'updated_at' => now()->setTimezone('America/Lima')->format('Y-m-d H:i:s'),
        ]);
        if (count($this->selected) == $retorno) {
            $this->success('Genial, ingresado correctamente!');
            $this->resetSelection();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }

    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    private function toggleModalEnvio()
    {
        $this->modalEnvio = !$this->modalEnvio;
    }

    private function resetSelection()
    {
        $this->modalEnvio = false;
        $this->selected = [];
    }
}
