<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Models\Package\Customer;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use App\Services\SearchService;
use App\Traits\LogCustom;

class CustomerLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Clientes';
    public $sub_title = 'Modulo de clientes';
    public $search = '';
    public $perPage = 10;
    public CustomerForm $customerForm;
    public bool $modalCustomer = false; // Variable para el modal de agregar cliente
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public function render()
    {
        $customers = Customer::where(
            fn($query)
            => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
        )->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, '*', 'page');
        return view('livewire.package.customer-live', compact('customers'));
    }
    public function openModal()
    {

        $this->customerForm->reset();
        $this->modalCustomer = !$this->modalCustomer;
    }

    public function create()
    {
        if ($this->customerForm->store()) {
            $this->success('Genial, guardado correctamente!');
            $this->openModal();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function edit(Customer $customer)
    {
        $this->openModal();
        $this->customerForm->setCustomer($customer);
    }
    public function update()
    {
        if ($this->customerForm->update()) {
            $this->success('Genial, guardado correctamente!');
            $this->openModal();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function estado(Customer $customer)
    {
        if ($this->customerForm->estado($customer->id)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function SearchDocument()
    {
        $this->customerForm->store();
    }
    public function delete(Customer $customer)
    {
        if ($this->customerForm->destroy($customer->id)) {
            $this->success('Genial, eliminado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
