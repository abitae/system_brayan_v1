<?php

namespace App\Livewire\Frontend;

use App\Models\Frontend\Message;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class MessageLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'Mensages';
    public string $sub_title = 'Modulo de mensages';
    public int $perPage = 10;
    public bool $modalMessage = false;
    public Message $message;
    public function render()
    {
        $messages = Message::latest()->paginate($this->perPage);
        return view('livewire.frontend.message-live', compact('messages'));
    }
    public function readMessage(Message $message)
    {
        $this->message = $message;
        $this->message->isActive = false;
        $this->message->save();
        $this->modalMessage = true;
        //dump($this->message);
    }
}
