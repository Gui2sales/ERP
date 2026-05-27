<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Busca extends Component
{
    public string $search = '';
    public array $results = [];
    public bool $showResults = false;

    public function updatedSearch()
    {
        if (strlen($this->search) < 1) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->results = DB::table('busca_telas_index')
            ->where(function ($query) {
                $query->whereRaw("LOWER(NOME_EXIBIDO) LIKE LOWER(?)", ["%{$this->search}%"])
                    ->orWhereRaw("SIGLA LIKE UPPER(?)", ["{$this->search}%"]);
            })
            ->where('ATIVO','=','1')
            ->limit(10)
            ->orderBy('SIGLA')
            ->get()
            ->toArray();

        $this->showResults = true;
    }

    public function render()
    {
        return <<<'HTML'
        <div class="d-flex formulario_pesquisa">
            <div class="d-flex w-100">
                <input 
                    type="search"
                    class="form-control d-inline-block h-10 w-100"
                    wire:model.live="search"
                    placeholder="Busca menu..."
                >
                @if($results)
                    <div class="caixa_pesquisa">
                        @foreach($results as $result)
                            <a href="{{route($result->ROTA)}}" class="d-block item_caixa_pesquisa">
                                {{ $result->NOME_EXIBIDO }} @if($result->SIGLA) ({{$result->SIGLA}}) @endif
                            </a>
                        @endforeach
                    </div>
                @elseif($search && !$results)
                    <div class="caixa_pesquisa">
                        <p class="d-block item_caixa_pesquisa">Nenhum resultado encontrado.</p>
                    </div>
                @endif
            </div>    
            <livewire:Components.Notificacoes>
        </div>
        HTML;
    }
}
