<?php
namespace App\Livewire\Configuration;

use App\Livewire\Forms\UserForm;
use App\Models\Configuration\Sucursal;
use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Role;

class UserLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public UserForm $userForm;
    public $title          = 'Usuarios';
    public $sub_title      = 'Modulo de usuarios';
    public int $perPage    = 10;
    public bool $modalUser = false;

    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->get();
        $roles     = Role::whereNotIn('name', ['SuperAdmin'])->get();
        $users     = User::where('email','!=','abel.arana@hotmail.com')->latest()->paginate($this->perPage);
        return view('livewire.configuration.user-live', compact('users', 'sucursals', 'roles'));
    }
    public function openModal()
    {
        $this->userForm->reset();
        $this->modalUser = ! $this->modalUser;
    }
    public function create()
    {
        if ($this->userForm->store()) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
        $this->openModal();
    }
    public function edit(User $user)
    {
        $this->openModal();
        $this->userForm->setUser($user);
    }
    public function update()
    {
        if ($this->userForm->update()) {
            $this->success('Genial, guardado correctamente!');

        } else {
            $this->error('Error, verifique los datos!');
        }
        $this->openModal();
    }
    public function delete(User $user)
    {
        if ($this->userForm->delete($user)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function estado(User $user)
    {
        if ($this->userForm->estado($user)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
