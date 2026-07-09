<?php

namespace App\Livewire\Configuration;

use App\Livewire\Forms\VehiculoForm;
use App\Models\Configuration\Vehiculo;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class VehiculoLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;

    public VehiculoForm $vehiculoForm;

    public $title = 'Vehículos';

    public $sub_title = 'Módulo de vehículos';

    public int $perPage = 10;

    public bool $modalVehiculo = false;

    public function render()
    {
        $vehiculos = Vehiculo::latest()->paginate($this->perPage);

        return view('livewire.configuration.vehiculo-live', compact('vehiculos'));
    }

    public function openModal(): void
    {
        $this->vehiculoForm->reset();
        $this->modalVehiculo = true;
    }

    public function openEditModal(Vehiculo $vehiculo): void
    {
        $this->vehiculoForm->reset();
        $this->vehiculoForm->setVehiculo($vehiculo);
        $this->modalVehiculo = true;
    }

    public function closeModal(): void
    {
        $this->modalVehiculo = false;
        $this->vehiculoForm->reset();
    }

    public function create(): void
    {
        if ($this->vehiculoForm->store()) {
            $this->success('Vehículo registrado correctamente');
            $this->closeModal();
            return;
        }

        $this->error('No se pudo guardar. Verifique los datos (la placa debe ser única).');
    }

    public function edit(): void
    {
        if ($this->vehiculoForm->update()) {
            $this->success('Vehículo actualizado correctamente');
            $this->closeModal();
            return;
        }

        $this->error('No se pudo actualizar. Verifique los datos.');
    }

    public function delete(Vehiculo $vehiculo): void
    {
        if ($this->vehiculoForm->delete($vehiculo)) {
            $this->success('Vehículo eliminado correctamente');
            return;
        }

        $this->error('No se pudo eliminar el registro.');
    }

    public function estado(Vehiculo $vehiculo): void
    {
        if ($this->vehiculoForm->estado($vehiculo)) {
            $this->success('Estado actualizado correctamente');
            return;
        }

        $this->error('No se pudo cambiar el estado.');
    }
}
