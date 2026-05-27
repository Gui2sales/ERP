<?php

namespace App\Livewire\Suprimentos\AprovaCotacao;

use App\Services\NewOpusSocketService;
use Livewire\Component;

class Observacoes extends Component
{
    public array $observacao = [];
    public bool $exibe = false;
    public string $frase = "";
    public string $conteudo = "";
    public bool $conteudoPreenchido = false;

    public string|int $itemId; 

    public function toggleExibe()
    {
        $this->exibe = !$this->exibe;
    }

    public function validaObservacao()
    {
        $totalVazias = 0;
        $total = count($this->observacao);

        foreach ($this->observacao as $item){
            if(empty($item)){
                $totalVazias = $totalVazias + 1;
            }
        }
        
        if(($total - $totalVazias) == 0 ){
            return $this->frase = "Ainda não há observações.";
        }
        else{
            return $this->frase = "";
        }
    }

    public function adicionaObservacao()
    {
        if($this->conteudoPreenchido){
            array_pop($this->observacao);
            $this->observacao[] = formata_texto_opus($this->conteudo);
        }
        else{
            $this->observacao[] =  formata_texto_opus($this->conteudo);
            $this->validaObservacao();
            $this->conteudoPreenchido = true;
        }

        $this->dispatch('recebeObservacao', itemId: $this->itemId, conteudo: formata_texto_opus($this->conteudo));

        $this->js('setTimeout(() => $wire.toggleExibe(), 1000);');
    } 

    public function render()
    {
        return <<<'HTML'
        <div>
            <button class="btn btn-primary botao_observacoes" wire:click="toggleExibe">
                Observações
            </button>
            
            @if($exibe)
                <div class="fundo_blur" wire:init="validaObservacao">
                    <div class="card_observacao container w-50" @click.outside="$wire.toggleExibe()">
                        <div class="row"> 
                            <h3 class="col-10 mt-4">Observações do item</h3>
                            <button class="btn col-2" wire:click="toggleExibe">
                                <i class="bi bi-x-lg fs-2"></i>
                            </button>
                            <hr>
                        </div>    
                        <div class="row">
                            @empty($frase)
                                @foreach($observacao as $obs)
                                    @if($obs != "")
                                        <div class="input-group mt-2">
                                            <textarea class="form-control" rows="2" readonly>{{ $obs }}</textarea>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="input-group mt-4">
                                    <textarea class="form-control" rows="1" readonly>{{$frase}}</textarea>
                                </div>
                            @endempty
                        </div>
                        <div class="row">
                            <div class="inline-block mt-5">
                                <label for="text">Adicionar Observação:</label>
                                <div class="input-group mt-2">
                                    <textarea class="form-control" rows="2" wire:model.defer="conteudo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-end">
                            <div class="inline-block mt-2 col-sm-3">
                                <button type="submit" wire:click="adicionaObservacao"
                                    @if($conteudoPreenchido)
                                        class="btn btn-primary w-100" >
                                        <i class="bi bi-plus-circle"> Alterar </i> 
                                    @else
                                        class="btn btn-success w-100" >
                                        <i class="bi bi-plus-circle"> Adicionar </i> 
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        HTML;
    }
}
