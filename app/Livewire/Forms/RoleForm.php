<?php

namespace App\Livewire\Forms;

use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    use LogCustom;
    public ?Role $role;

    #[Validate('required|min:4|unique:roles')]
    public $name = '';

    public function setRole(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
    }
    public function store($permisions)
    {
        try {
            $this->validate();
            Role::create([
                'name' => $this->name,
            ])->syncPermissions($permisions);
            $this->infoLog('Role store', $this->name);
            $this->reset();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role store', $e);
            return false;
        }
    }
    public function update($permisions)
    {
        try {
            $this->role->update([
                'name' => $this->name,
            ]);
            $this->role->syncPermissions($permisions);
            $this->infoLog('Role update', $this->name);
            $this->reset();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role update', $e);
            return false;
        }
    }
    public function delete(Role $role)
    {
        try {
            $role->delete();
            $this->infoLog('Role delete', $role->email);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role delete', $e);
            return false;
        }
    }

}
