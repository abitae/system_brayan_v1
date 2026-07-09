<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    use LogCustom;
    public ?User $user;
    #[Validate(['required', 'string', 'max:255'])]
    public $name = '';
    #[Validate('required')]
    #[Validate('unique:' . User::class)]
    public $email = '';
    #[Validate('required')]
    public $password = 'password';
    #[Validate('required')]
    public $sucursal_id = '';
    #[Validate('required')]
    public $role = '';
    public function setUser(User $user)
    {
        //dd($user->getRoleNames()->first());
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->sucursal_id = $user->sucursal_id;
        $this->role = $user->getRoleNames()->first();
    }
    public function store()
    {
        try {
            $this->validate();
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('password'),
                'sucursal_id' => $this->sucursal_id,
            ])->syncRoles([$this->role]);
            $this->infoLog('User store ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('User store', $e);
            return false;
        }
    }
    public function update()
    {
        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'sucursal_id' => $this->sucursal_id,
            ]);
            $this->user->syncRoles([$this->role]);
            $this->infoLog('User update ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('User update', $e);
            return false;
        }
    }
    public function delete(User $user)
    {
        try {
            $user->delete();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('User delete', $e);
            return false;
        }
    }
    public function estado(User $user)
    {
        try {
            $user->update([
                'isActive' => !$user->isActive,
            ]);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('User delete', $e);
            return false;
        }
    }
}
