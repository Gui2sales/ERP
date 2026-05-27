<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class BoxNotificacao extends Component
{
    public string $titulo = "";
    public string $resposta ="";
    public bool $exibeBox = false;

    #[On('notificacao')]
    public function exibeNotifiicacao(string $msg) 
    {
        $this->resposta = $msg;
        $this->exibeBox = true;
    }

    public function fechaModal()
    {
        $this->exibeBox = false;
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            @if($exibeBox)
                <div class="card card-shadow box_notificacao container">
                    <div class="row mb-1"> 
                        <h3 class="inline-block col-10 mt-1">{{$titulo}}</h3>
                        <button class="inline-block col-1" wire:click="fechaModal"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <hr class="mb-2">
                    <P>{{$resposta}}</P>
                </div>
            @endif
        </div>
        HTML;
    }
}
