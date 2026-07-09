<?php

namespace App\Livewire\Frontend;

use App\Models\Frontend\Reclamacion;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ReclamoLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'Reclamaciones';
    public string $sub_title = 'Modulo de reclamaciones';
    public int $perPage = 10;
    public bool $modalReclamo= false;
    public Reclamacion $reclamo;
    public function render()
    {
        $reclamos = Reclamacion::latest()->paginate($this->perPage);
        return view('livewire.frontend.reclamo-live',compact('reclamos'));
    }
    public function readReclamo(Reclamacion $reclamo){
        $this->reclamo = $reclamo;
        $this->reclamo->isActive = false;
        $this->reclamo->save();
        $this->modalReclamo = true;
    }
}
