<?php

namespace App\Livewire\Forms;

use App\Models\Caja\ExitCaja;
use App\Traits\CajaTrait;
use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ExitCajaForm extends Form
{
    use LogCustom;
    use CajaTrait;
    #[Validate('required')]
    public $caja_id = '';
    #[Validate('required')]
    public $monto_exit = 0;
    #[Validate('required')]
    public $description = '';
    #[Validate('required')]
    public $metodo_pago = 'Efectivo';
    #[Validate('required')]
    public $tipo_exit = '';
    public function store()
    {
        try {
            //dd($this->caja_id, $this->monto_exit, $this->description,$this->metodo_pago, $this->tipo_exit);
            $this->validate();
            $this->cajaExit($this->caja_id, $this->monto_exit, $this->description,$this->metodo_pago, $this->tipo_exit);
            $this->infoLog('ExitCaja store');
            return true;
        } catch (\Exception $e) {
            $this->errorLog('ExitCaja store', $e);
            return false;
        }
    }
}
