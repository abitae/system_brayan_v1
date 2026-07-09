<?php

namespace App\Livewire\Configuration;

use App\Livewire\Forms\TransportistaForm;
use App\Models\Configuration\Transportista;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class TransportistaLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public TransportistaForm $transportistaForm;
    public $title = 'CHOFERES';
    public $sub_title = 'Modulo de choferes';
    public int $perPage = 10;
    public function render()
    {
        $transportistas = Transportista::latest()->paginate($this->perPage);

        return view('livewire.configuration.transportista-live', compact('transportistas'));
    }

    public bool $modalTransportista = false;

    public function openModal(): void
    {
        $this->transportistaForm->reset();
        $this->modalTransportista = true;
    }

    public function openEditModal(Transportista $transportista): void
    {
        $this->transportistaForm->reset();
        $this->transportistaForm->setTransportista($transportista);
        $this->modalTransportista = true;
    }

    public function closeModal(): void
    {
        $this->modalTransportista = false;
        $this->transportistaForm->reset();
    }

    public function create(): void
    {
        if ($this->transportistaForm->store()) {
            $this->success('Chofer registrado correctamente');
            $this->closeModal();
            return;
        }

        $this->error('No se pudo guardar. Verifique los datos (DNI y licencia deben ser únicos).');
    }

    public function edit(): void
    {
        if ($this->transportistaForm->update()) {
            $this->success('Chofer actualizado correctamente');
            $this->closeModal();
            return;
        }

        $this->error('No se pudo actualizar. Verifique los datos.');
    }

    public function delete(Transportista $transportista): void
    {
        if ($this->transportistaForm->delete($transportista)) {
            $this->success('Chofer eliminado correctamente');
            return;
        }

        $this->error('No se pudo eliminar el registro.');
    }

    public function estado(Transportista $transportista): void
    {
        if ($this->transportistaForm->estado($transportista)) {
            $this->success('Estado actualizado correctamente');
            return;
        }

        $this->error('No se pudo cambiar el estado.');
    }
}
