<?php

namespace App\Livewire\Configuration;

use App\Livewire\Forms\SucursalForm;
use App\Models\Configuration\Sucursal;
use App\Services\ServiceTableSunat;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class SucursalLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public SucursalForm $sucursalForm;
    public $title = 'Sucursales';
    public $sub_title = 'Modulo de sucursales';
    public int $perPage = 10;
    public bool $modalSucursal = false;
    public function render()
    {
        $sunatTableService = new ServiceTableSunat();
        $ubigeos       = $sunatTableService->getAll('ubigeo');
        $sucursales = Sucursal::latest()->paginate($this->perPage);
        return view('livewire.configuration.sucursal-live', compact('sucursales', 'ubigeos'));
    }
    public function openModal()
    {
        $this->sucursalForm->reset();
        $this->modalSucursal = !$this->modalSucursal;
    }
    public function create()
    {
        if ($this->sucursalForm->store()) {
            $this->success('Genial, guardado correctamente!');
            $this->openModal();
        } else {
            $this->error('Error, verifique los datos!');
        }

    }
    public function update(Sucursal $sucursal)
    {
        $this->openModal();
        $this->sucursalForm->setSucursal($sucursal);
    }
    public function edit()
    {
        if ($this->sucursalForm->update()) {
            $this->success('Genial, guardado correctamente!');
            $this->openModal();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function delete(Sucursal $sucursal)
    {
        if ($this->sucursalForm->delete($sucursal)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function estado(Sucursal $sucursal)
    {
        if ($this->sucursalForm->estado($sucursal)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
