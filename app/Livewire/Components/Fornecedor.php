<?php

namespace App\Livewire\Components;

use App\Services\NewOpusSocketService;
use Livewire\Component;

class Fornecedor extends Component
{
    public string $codfor = "";
    public string $nome;
    public bool $exibeFornece = false;
    public $fornecedor;

    public function mount($codfor)
    {
        $this->codfor = $codfor;
    }

    public function toggleExibeFornecedor(NewOpusSocketService $opus)
    {
        $this->exibeFornece = !$this->exibeFornece;

        if($this->exibeFornece){
            $this->buscaFornecedor($opus);
        }
    }

    public function buscaFornecedor($opus)
    {
        $this->fornecedor = $opus->getFornecedor($this->codfor);
    }

    public function render()
    {    
        return <<<'HTML'
        <div>
            <span class="fonte_clicavel" wire:click="toggleExibeFornecedor">{{$codfor . " - ". $nome}}</span>
            @if($exibeFornece)
                <div class="fundo_modal">
                    <div class="card_modal container-fluid">
                        <div class="d-flex justify-content-between align-items-center ml-3 mt-2">
                            <h3 class="card-title">Fornecedor: {{$codfor . " - " . $nome}} </h3>
                            <button class="btn" wire:click='toggleExibeFornecedor'><i class="bi bi-x-lg"></i></a>
                        </div>
                        <div class="row p-3">
                            <div class="d-flex col-9 mb-1">
                                <div class="col-2 div_nome">Nome</div>
                                <div class="col-10 div_campo">{{$fornecedor['NOMEFOR']}}</div>
                            </div>
                            <div class="d-flex col-3 mb-1">
                                <div class="col-3 div_nome">Tipo</div>
                                <div class="col-9 div_campo">{{$fornecedor['TIPOFOR']}}</div>
                            </div>

                            <div class="d-flex col-5 mb-1">
                                <div class="col-4 div_nome">CNPJ</div>
                                <div class="col-8 div_campo">{{$fornecedor['CGCFOR']}}</div>
                            </div>
                            <div class="d-flex col-7 mb-1">
                                <div class="col-5 div_nome">Inscrição Estadual</div>
                                <div class="col-7 div_campo">{{$fornecedor['INSFOR']}}</div>
                            </div>
                            
                            <div class="d-flex col-12 mb-1">
                                <div class="col-2 div_nome">Endereço</div>
                                <div class="col-10 div_campo">{{$fornecedor['ENDFOR'] . ' - ' . $fornecedor['BAIFOR']}}</div>
                            </div>

                            <div class="d-flex col-4 mb-1">
                                <div class="col-4 div_nome">CEP</div>
                                <div class="col-8 div_campo">{{$fornecedor['CEPFOR']}}</div>
                            </div>
                            <div class="d-flex col-3 mb-1">
                                <div class="col-5 div_nome">País</div>
                                <div class="col-7 div_campo">{{$fornecedor['PAISFOR']}}</div>
                            </div>
                            <div class="d-flex col-5 mb-1">
                                <div class="col-5 div_nome">Est / Mun</div>
                                <div class="col-7 div_campo">{{$fornecedor['ESTFOR'] . " / ".$fornecedor['MUNFOR']}}</div>
                            </div>

                            <div class="d-flex col-12 mb-1">
                                <div class="col-3 div_nome">Nome do contato</div>
                                <div class="col-9 div_campo">{{$fornecedor['NOMECONT']}}</div>
                            </div>

                            <div class="d-flex col-12 mb-1">
                                <div class="col-4 div_nome">Numero da Conta Contabil</div>
                                <div class="col-8 div_campo">{{$fornecedor['NUMCONTA']}}</div>
                            </div>

                            <div class="d-flex col-12">
                                <div class="col-2 div_nome">Observações</div>
                                <div class="col-10 div_campo">{{$fornecedor['OBSFOR']}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        HTML;
    }
}
