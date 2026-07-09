<?php
namespace App\Livewire\Configuration;

use App\Livewire\Forms\RoleForm;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public RoleForm $roleForm;
    public $title          = 'Roles';
    public $sub_title      = 'Modulo de roles y permisos';
    public int $perPage1   = 5;
    public int $perPage2   = 5;
    public bool $modalRole = false;
    public array $selected = [];
    public $search         = '';
    public function render()
    {
        $roles    = Role::where('name', '!=', 'SuperAdmin')->paginate($this->perPage1, '*', 'page1');
        $permisos = Permission::where('name', '!=', 'super.admin')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage2, '*', 'page2');
        return view('livewire.configuration.role-live', compact('roles', 'permisos'));
    }
    public function openModal()
    {
        $this->selected  = [];
        $this->modalRole = ! $this->modalRole;
    }
    public function create()
    {
        if ($this->roleForm->store($this->selected)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
        $this->openModal();
        $this->resetPage();
    }
    public function update(Role $role)
    {
        $this->openModal();
        $this->roleForm->setRole($role);
        $this->selected = $role->permissions->pluck('name')->toArray();

    }
    public function edit()
    {
        if ($this->roleForm->update($this->selected)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
        $this->openModal();
        $this->resetPage();
    }
    public function delete(Role $role)
    {
        if ($this->roleForm->delete($role)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }

}
