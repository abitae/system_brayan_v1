<?php

namespace App\Livewire\Pagar;

use App\Traits\UtilsTrait;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class EncomiendaPagar extends Component
{
    use Toast, UtilsTrait, WithPagination, WithoutUrlPagination;
    public $title = 'PAGAR ENCOMIENDA';
    public $sub_title = 'Pagar encomienda';
    public $encomienda;
    public function render()
    {
        return view('livewire.pagar.encomienda-pagar');
    }
}
