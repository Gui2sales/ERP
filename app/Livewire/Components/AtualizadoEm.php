<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class AtualizadoEm extends Component
{
    public $timestamp;

    #[On('timestamp-changed')]
    public function handleTimestampUpdate($newTimestamp)
    {
        $this->timestamp = date('d/m/Y H:i:s', $newTimestamp);
    }

    public function mount($timestamp)
    {        
        $this->timestamp = date('d/m/Y H:i:s', $timestamp);
    }

    public function render()
    {
        return <<<'HTML'
        <div class="d-inline-block">
            <span class="fs-6">Atualizado em {{$timestamp}}</span>
        </div>
        HTML;
    }
}
