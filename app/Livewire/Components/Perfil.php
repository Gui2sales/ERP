<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Perfil extends Component
{
    public $exibe = false;
    public $usuario;

    public function mount()
    {
        $this->usuario = Auth::user();
    }

    public function toggleExibe()
    {
        $this->exibe = !$this->exibe;
    }

    public function toggleExibeOff()
    {
        $this->exibe = false;
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return <<<'HTML'
        <div class="perfil_usuario" wire:click="toggleExibe" wire:click.outside="toggleExibeOff">
            <i class="bi bi-person-circle icone_grande"></i>
            <span class="only_pc">{{Str::limit(ucwords(strtolower($usuario->name)), 16, "...")}}</span>
            @if($exibe)
                <div id="card_asside" class="card_asside_perfil z-3">
                    <h5 class="mb-2">Ações</h5>
                    <hr class="mb-3">
                    <p class="card_asside_item">Perfil</p>
                    <p class="card_asside_item" wire:click="logout">Sair</p>
                </div>
            @endif
        </div>
        HTML;
    }
}
