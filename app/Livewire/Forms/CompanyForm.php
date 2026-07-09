<?php

namespace App\Livewire\Forms;

use App\Models\Configuration\Company;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Livewire\WithFileUploads;

class CompanyForm extends Form
{
    use WithFileUploads;
    use LogCustom;

    public ?Company $company;
    public $ruc = '';
    public $razonSocial = '';
    public $address = '';
    public $email = '';
    public $telephone = '';
    public $ubigeo = '';
    public $ctaBanco = '';
    public $pin = '';
    public $sol_user = '';
    public $sol_pass = '';
    public $client_id = '';
    public $client_secret = '';

    public function setCompany(Company $company)
    {
        $this->company = $company;
        $this->fill($company->toArray());
    }
    public function update()
    {

        try {
            $rules = [
                'ruc' => 'required|string|max:11|min:11',
                'razonSocial' => 'required|string',
                'address' => 'required|string|max:255',
                'email' => 'required|string|email',
                'telephone' => 'required|string',
                'pin' => 'required|string',
                'ctaBanco' => 'required|string',
                'ubigeo' => 'required|string',
                'sol_user' => 'required|string',
                'sol_pass' => 'required|string',
                'client_id' => 'required|string',
                'client_secret' => 'required|string',
            ];

            $this->validate($rules);
            $this->company->update(
                [
                    'ruc' => $this->ruc,
                    'razonSocial' => $this->razonSocial,
                    'address' => $this->address,
                    'email' => $this->email,
                    'telephone' => $this->telephone,
                    'pin' => $this->pin,
                    'ctaBanco' => $this->ctaBanco,
                    'ubigeo' => $this->ubigeo,
                    'sol_user' => $this->sol_user,
                    'sol_pass' => $this->sol_pass,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                ]
            );
            $this->infoLog('Company ' . ($this->company->exists ? 'update' : 'store') . ' ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Company ' . ($this->company->exists ? 'update' : 'store'), $e);
            return false;
        }
    }

}
