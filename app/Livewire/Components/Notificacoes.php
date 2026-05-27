<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Notificacoes extends Component
{
    public $notificacoes = [];
    public bool $show_modal = false;
    public array $expandedItems = [];
    public int $quantidadeNotificacoes = 0;

    public function buscaNovasNotificacoes()
    {
        $this->quantidadeNotificacoes = DB::table("notificacoes")->get()->count();
    }

    public function atualizaNotificacoes()
    {
        $this->notificacoes = DB::table("notificacoes")->get();
    }

    public function exibe()
    {
        if ($this->show_modal == false)
        {
            return $this->show_modal = true;
        }
        else 
        {
            return $this->show_modal = false;
        }
    }

    public function esconde()
    {
        return $this->show_modal = false;
    }

    public function toggleItem($notificacaoId)
    {
        if (isset($this->expandedItems[$notificacaoId])) {
            unset($this->expandedItems[$notificacaoId]);
        } else {
            $this->expandedItems[$notificacaoId] = true;
        }
    }

    public function isExpanded($notificacaoId)
    {
        return isset($this->expandedItems[$notificacaoId]);
    }

    public function render()
    {
        $this->buscaNovasNotificacoes();

        return <<<'HTML'
        <div>
            <button type="button" class="btn d-inline-block" wire:click="exibe">
                <p class="sino @if($show_modal) menu_ativo @endif">🔔</p>
                <div class="quantidade_notificacao" wire:poll.30s="buscaNovasNotificacoes">
                    <i class="badge text-bg-primary rounded-pill">{{$quantidadeNotificacoes}}</i>
                </div>
            </button>
            @if($show_modal)
                <div class="card" id="notificacoesModal" wire:show="atualizaNotificacoes">
                    <div class="card-header d-flex justify-content-between">
                        <span id="titulo_notificacoes">Notificações</span>
                        <i class="bi bi-x-lg inline-block mr-2" style="cursor:pointer;" wire:click="esconde"></i>
                    </div>
                    <div>
                        @forelse($notificacoes as $ntf)
                            <div wire:key="{{ $ntf->id }}">
                                <p wire:click="toggleItem('{{$ntf->id}}')" class="notificacao_titulo">{{$ntf->titulo}}</p>
                                <div class="notificacao_msg" @if(!$this->isExpanded($ntf->id)) hidden @endif >{{$ntf->mensagem}}</div>
                            </div>
                        @empty
                            <p class="notificacao_msg"> Não há notificações!</p>
                        @endforelse
                    </div>
                    <div class="card-footer"></div>
                </div>
            @endif
        </div>
        HTML;
    }
}
