<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Package\Paquete;

class paqueteForm extends Form
{
    #[Validate('required|numeric')]
    public $encomienda_id;
    #[Validate('required|numeric')]
    public $cantidad;
    #[Validate('required')]
    public $description;
    #[Validate('required|numeric')]
    public $peso;
    #[Validate('required|numeric')]
    public $amount;
    public function save($paquetes)
    {
        
    }
}
