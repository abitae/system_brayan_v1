<?php
namespace App\Livewire\Forms;

use App\Models\Package\Customer;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use Livewire\Form;

class CustomerForm extends Form
{
    use LogCustom, SearchDocument;

    public ?Customer $customer;
    public $type_code = '';
    public $code      = '';
    public $name      = '';
    public $phone     = '';
    public $email     = '';
    public $address   = '';
    public $ubigeo    = '';
    public $isActive  = true;

    protected $rules = [
        'type_code' => 'required',
        'code'      => 'required|numeric|digits_between:8,11',
        'name'      => 'required',
    ];

    protected $messages = [
        'type_code.required'  => 'El campo es requerido.',
        'code.required'       => 'Num Documento es requerido.',
        'code.numeric'        => 'El documento debe de ser numerico.',
        'code.digits_between' => 'El documento debe de tener entre 8 y 11 caracterisricas.',
        'name'                => 'El campo es requerido.',
    ];
    public function setCustomer(Customer $customer)
    {
        $this->customer  = $customer;
        $this->type_code = $customer->type_code;
        $this->code      = $customer->code;
        $this->name      = $customer->name;
        $this->phone     = $customer->phone;
        $this->email     = $customer->email;
        $this->address   = $customer->address;
        $this->ubigeo    = $customer->ubigeo;
    }

    public function store()
    {
        try {
            $customer = Customer::where('type_code', $this->type_code)->where('code', $this->code)->first();
            if ($customer) {
                $this->setCustomer($customer);
                return true;
            } else {
                switch ($this->type_code) {
                    case '1':
                        $tipo = 'dni';
                        break;
                    case '6':
                        $tipo = 'ruc';
                        break;
                }
                $data = $this->searchComplete($tipo, $this->code);

                if ($data['encontrado']) {
                    $this->populateCustomerData($data['data']);
                    $customer = Customer::Create(
                        [
                        'type_code' => $this->type_code,
                        'code' => $this->code,
                        'name' => $this->name,
                        'phone' => $this->phone,
                        'email' => $this->email,
                        'address' => $this->address,
                        'ubigeo' => $this->ubigeo]
                    );
                    $this->setCustomer($customer);
                    $this->infoLog('Customer store ' . $this->code);
                    return true;
                }
                else{
                    return false;
                }
            }
            $customer = null;
            return false;
        } catch (\Exception $e) {
            $this->errorLog('Customer store', $e);
            return false;
        }
    }

    public function update()
    {
        try {
            $this->validate();
            $customer = Customer::updateOrCreate(
                ['type_code' => $this->type_code, 'code' => $this->code],
                ['name' => $this->name, 'phone' => $this->phone, 'email' => $this->email, 'address' => $this->address, 'ubigeo' => $this->ubigeo]
            );
            $this->infoLog('Customer update ' . $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Customer update', $e);
            return false;
        }
    }

    public function destroy($id)
    {
        return $this->performAction($id, function ($customer) {
            $customer->delete();
        }, 'Customer destroy');
    }

    public function estado($id)
    {
        return $this->performAction($id, function ($customer) {
            $customer->isActive = ! $customer->isActive;
            $customer->save();
        }, 'Customer estado');
    }

    private function populateCustomerData($data)
    {
        if ($this->type_code == '1') {
            $this->name = $data->nombre;
        } elseif ($this->type_code == '6') {
            $this->name    = $data->razon_social;
            $this->address = $data->direccion;
            $this->ubigeo = $data->codigo_ubigeo;

        }
    }
    private function performAction($id, callable $action, $logMessage)
    {
        try {
            $customer = Customer::find($id);
            $action($customer);
            $this->infoLog($logMessage . ' ' . $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog($logMessage, $e);
            return false;
        }
    }
}
