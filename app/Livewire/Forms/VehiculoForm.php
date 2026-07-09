<?php

namespace App\Livewire\Forms;

use App\Models\Configuration\Vehiculo;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VehiculoForm extends Form
{
    use LogCustom;
    public ?Vehiculo $vehiculo = null;
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $marca = '';
    #[Validate('required')]
    public $modelo = '';
    #[Validate('required')]
    public $tipo = '';
    public $mtc = '';
    #[Validate('required')]
    public $nroCirculacion = '';
    #[Validate('required')]
    public $nroAutorizacion = '';
    public function setVehiculo(Vehiculo $vehiculo)
    {
        $this->vehiculo = $vehiculo;
        $this->name = $vehiculo->name;
        $this->marca = $vehiculo->marca;
        $this->modelo = $vehiculo->modelo;
        $this->tipo = $vehiculo->tipo;
        $this->mtc = $vehiculo->mtc;
        $this->nroCirculacion = $vehiculo->nroCirculacion;
        $this->nroAutorizacion = $vehiculo->nroAutorizacion;
    }
    public function store()
    {
        try {
            $this->validate();
            Vehiculo::create([
                'name' => $this->name,
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'tipo' => $this->tipo,
                'mtc' => $this->mtc,
                'nroCirculacion' => $this->nroCirculacion,
                'nroAutorizacion' => $this->nroAutorizacion,
            ]);
            $this->infoLog('Vehiculo store ' . Auth::user()->name);
            return true;
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->errorLog('Vehiculo store', $e);
            return false;
        }
    }
    public function update()
    {
        try {
            $this->validate();
            $this->vehiculo->update([
                'name' => $this->name,
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'tipo' => $this->tipo,
                'mtc' => $this->mtc,
                'nroCirculacion' => $this->nroCirculacion,
                'nroAutorizacion' => $this->nroAutorizacion,
            ]);
            $this->infoLog('Vehiculo update ' . Auth::user()->name);
            return true;
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->errorLog('Vehiculo update', $e);
            return false;
        }
    }
    public function delete(Vehiculo $Vehiculo)
    {
        try {
            $Vehiculo->delete();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Vehiculo delete', $e);
            return false;
        }
    }
    public function estado(Vehiculo $Vehiculo)
    {
        try {
            $Vehiculo->update([
                'isActive' => !$Vehiculo->isActive,
            ]);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Vehiculo delete', $e);
            return false;
        }
    }
}
