<?php

namespace App\Livewire\Forms;

use App\Models\Configuration\Transportista;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransportistaForm extends Form
{
    use LogCustom;
    public ?Transportista $transportista = null;
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $licencia = '';
    #[Validate('required')]
    public $dni = '';
    #[Validate('required')]
    public $tipo = '';
    public function setTransportista(Transportista $transportista)
    {
        $this->transportista = $transportista;
        $this->name = $transportista->name;
        $this->licencia = $transportista->licencia;
        $this->dni = $transportista->dni;
        $this->tipo = $transportista->tipo;
    }
    public function store()
    {
        try {
            $this->validate();
            Transportista::create([
                'type_code' => '1',
                'name' => $this->name,
                'licencia' => $this->licencia,
                'dni' => $this->dni,
                'tipo' => $this->tipo,
            ]);
            $this->infoLog('Transportista store ' . Auth::user()->name);
            return true;
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->errorLog('Transportista store', $e);
            return false;
        }
    }
    public function update()
    {
        try {
            $this->validate();
            $this->transportista->update([
                'type_code' => '1',
                'name' => $this->name,
                'licencia' => $this->licencia,
                'dni' => $this->dni,
                'tipo' => $this->tipo,
            ]);
            $this->infoLog('Transportista update ' . Auth::user()->name);
            return true;
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->errorLog('Transportista update', $e);
            return false;
        }
    }
    public function delete(Transportista $Transportista)
    {
        try {
            $Transportista->delete();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Transportista delete', $e);
            return false;
        }
    }
    public function estado(Transportista $Transportista)
    {
        try {
            $Transportista->update([
                'isActive' => !$Transportista->isActive,
            ]);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Transportista delete', $e);
            return false;
        }
    }
}
