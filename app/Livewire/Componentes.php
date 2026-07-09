<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use Mary\Traits\Toast;


class Componentes extends Component
{
    use Toast;
    public bool $showDrawer1 = false;
    public bool $showDrawer2 = false;
    public bool $showDrawer3 = false;
    public bool $myModal1 = false;
    public bool $myModal2 = false;

    public int $step = 1;
    public ?int $user_searchable_id = null;

    // Options list
    public Collection $usersSearchable;
    public function mount()
    {
        // Fill options when component first renders
        $this->search();
    }
    public function render()
    {
        $users = User::all();

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-red-500/20 w-1 text-black'],
            ['key' => 'name', 'label' => 'Nice Name', 'class' => 'text-black'],
            ['key' => 'email', 'label' => 'Email', 'class' => 'text-black']
        ];
        return view('livewire.componentes', compact('users', 'headers'));
    }
    public function save()
    {
        $this->success('We are done, check it out');
    }

    public function save2()
    {
        $this->error(
            'It will last just 1 second ...',
            timeout: 1000,
            position: 'toast-bottom toast-start'
        );
    }
    public function save3()
    {
        $this->warning(
            'It is working with redirect',
            'You were redirected to another url ...',
            redirectTo: '/docs/components/form'
        );
    }
    public function save4()
    {
        $this->warning(
            'Wishlist <u>updated</u>',
            'You will <strong>love it :)</strong>',
            position: 'toast-bottom toast-start',
            icon: 'o-heart',
            css: 'bg-pink-500 text-base-200'
        );
    }
    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->user_searchable_id)->get();

        $this->usersSearchable = User::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);     // <-- Adds selected option
    }
}
