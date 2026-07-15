<?php

namespace App\Livewire;

use App\Models\Configuration\SubscriptionNotice;
use Livewire\Component;

class SubscriptionEndNotice extends Component
{
    public bool $show = false;

    public bool $isClose = false;

    public ?string $fechaVencimiento = null;

    public function mount(): void
    {
        $notice = SubscriptionNotice::query()->first();

        if (! $notice || ! $notice->is_activo) {
            return;
        }

        $this->show = true;
        $this->isClose = (bool) $notice->is_close;
        $this->fechaVencimiento = $notice->fecha_vencimiento
            ? $notice->fecha_vencimiento->format('d/m/Y')
            : null;
    }

    public function close(): void
    {
        if ($this->isClose) {
            return;
        }

        $this->show = false;
    }

    public function render()
    {
        return view('livewire.subscription-end-notice');
    }
}
