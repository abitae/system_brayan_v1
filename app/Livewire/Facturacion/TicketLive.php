<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Ticket;
use App\Traits\UtilsTrait;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class TicketLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    use UtilsTrait;
    public string $title = 'TICKETS DE ENVIO';
    public string $sub_title = 'Modulo reporte de ticket';
    public int $perPage = 20;

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
        $tickets = Ticket::query()
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
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.facturacion.ticket-live', compact('tickets'));
    }
}
