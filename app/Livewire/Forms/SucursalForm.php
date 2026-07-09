<?php

namespace App\Livewire\Forms;

use App\Models\Configuration\Sucursal;
use App\Services\ServiceTableSunat;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SucursalForm extends Form
{
    use LogCustom;

    public ?Sucursal $sucursal = null;
    #[Validate('required|max:3|unique:sucursals,code')]
    public $code = '';
    #[Validate('required|max:4')]
    public $codeSunat = '';
    #[Validate('required|numeric|min:0|max:100')]
    public $igv = 18;
    #[Validate('required')]
    public $serieFactura = '';
    #[Validate('required')]
    public $serieBoleta = '';
    #[Validate('required')]
    public $serieGuiaRemision = '';
    #[Validate('required')]
    public $serieNotaCreditoFactura = '';
    #[Validate('required')]
    public $serieNotaCreditoBoleta = '';
    #[Validate('required')]
    public $serieNotaDebitoFactura = '';
    #[Validate('required')]
    public $serieNotaDebitoBoleta = '';
    #[Validate('required')]
    public $color = '';
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $departamento = '';
    #[Validate('required')]
    public $provincia = '';
    #[Validate('required')]
    public $distrito = '';
    #[Validate('required')]
    public $urbanizacion = '';
    #[Validate('required')]
    public $address = '';
    #[Validate('required')]
    public $phone = '';
    #[Validate('required|email')]
    public $email = '';
    #[Validate('required')]
    public $ubigeo = '';

    public function setSucursal(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
        $this->fill($sucursal->toArray());
    }

    public function store()
    {
        try {
            $this->validate();
            $sucursal = new Sucursal();
            $sucursal->fill($this->validate())->save();
            $this->infoLog('Sucursal store' . ' ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal store', $e);
            return false;
        }
    }

    public function update()
    {
        try {
            $rules = [
                'codeSunat' => 'required|max:4',
                'igv' => 'required|numeric|min:0|max:100',
                'serieFactura' => 'required',
                'serieBoleta' => 'required',
                'serieGuiaRemision' => 'required',
                'serieNotaCreditoFactura' => 'required',
                'serieNotaCreditoBoleta' => 'required',
                'serieNotaDebitoFactura' => 'required',
                'serieNotaDebitoBoleta' => 'required',
                'color' => 'required',
                'name' => 'required',
                'departamento' => 'required',
                'provincia' => 'required',
                'distrito' => 'required',
                'urbanizacion' => 'required',
                'address' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'ubigeo' => 'required',
            ];
            $messages = [
                'codeSunat.required' => 'El código Sunat es requerido',
                'codeSunat.max' => 'El código Sunat debe tener máximo 4 caracteres',
                'igv.required' => 'El IGV es requerido',
                'igv.numeric' => 'El IGV debe ser un número',
                'igv.min' => 'El IGV debe ser mayor o igual a 0',
                'serieFactura.required' => 'La serie de factura es requerida',
                'serieBoleta.required' => 'La serie de boleta es requerida',
                'serieGuiaRemision.required' => 'La serie de guía remisión es requerida',
                'serieNotaCreditoFactura.required' => 'La serie de nota de crédito factura es requerida',
                'serieNotaCreditoBoleta.required' => 'La serie de nota de crédito boleta es requerida',
                'serieNotaDebitoFactura.required' => 'La serie de nota de débito factura es requerida',
                'serieNotaDebitoBoleta.required' => 'La serie de nota de débito boleta es requerida',
                'color.required' => 'El color es requerido',
                'name.required' => 'El nombre es requerido',
                'departamento.required' => 'El departamento es requerido',
                'provincia.required' => 'La provincia es requerida',
                'distrito.required' => 'El distrito es requerido',
                'urbanizacion.required' => 'La urbanización es requerida',
                'address.required' => 'La dirección es requerida',
                'phone.required' => 'El teléfono es requerido',
                'phone.numeric' => 'El teléfono debe ser un número',
                'email.required' => 'El email es requerido',
                'email.email' => 'El email debe ser un email válido',
                'ubigeo.required' => 'El ubigeo es requerido',
            ];
            $this->sucursal->update($this->validate($rules, $messages));
            $this->infoLog('Sucursal  update' . ' ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal  update', $e);
            return false;
        }
    }

    public function delete(Sucursal $sucursal)
    {
        try {
            $sucursal->delete();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal delete', $e);
            return false;
        }
    }

    public function estado(Sucursal $sucursal)
    {
        try {
            $sucursal->update(['isActive' => !$sucursal->isActive]);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal estado', $e);
            return false;
        }
    }
}
