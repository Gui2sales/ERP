<?php

namespace App\Livewire\Suprimentos\AprovaCotacao;

use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

use function Illuminate\Support\seconds;

class ListaItens extends Component
{
    public $exibeSCIT = false;
    public $expandAll = false;
    public $filial;
    public $cotacao;
    public $cotacaoItens = [];
    public $expandedItems = [];
    public $expandedHistorico = [];
    public array $selecionados = [];
    protected $indice = 0;
    public $msgErro = "";
    protected NewOpusSocketService $opusService;
    public $observacoes = [];
    public $enviaOpus = [];
    public $retornoOpus = "";
    public $timestamp = "";

    #[Validate('required')]
    public $senhaAprovacao = '';
    
    public function mount($filial, $cotacao): void
    {
        $this->filial = $filial;
        $this->cotacao = $cotacao;
    }

    #[On('recebeObservacao')]
    public function atualizaObservacoes(string|int $itemId, $conteudo)
    {
        $this->observacoes[$itemId] = [ 'observacao' => $conteudo];
    }

    public function loadExibeSCIT(NewOpusSocketService $opusService) 
    {   
        $userId = Auth::user()->user;
        $this->cotacaoItens = $opusService->getSolicitacaoCompraSuprimentoItens($this->filial, $this->cotacao);
        // DD($this->cotacaoItens);
        $cacheKey = "opus.suprimentos.itens.{$this->filial}.{$this->cotacao}.{$userId}";
        $this->timestamp = DB::table('cache')->select('expiration')->where('key', '=', $cacheKey)->first()->expiration;
        $this->timestamp = $this->timestamp - 300;
        
        $this->exibeSCIT = true;
    }

    public function toggleItem($itemId)
    {
        if (isset($this->expandedItems[$itemId])) {
            unset($this->expandedItems[$itemId]);
        } else {
            $this->expandedItems[$itemId] = true;
        }

        $this->syncExpandAllState();
    }

    public function toggleAll()
    {
        $this->expandAll = !$this->expandAll;

        if ($this->expandAll) {
            foreach ($this->cotacaoItens['scit'] as $item) {
                $this->expandedItems[$item['itemSolicitacao']] = true;
            }
        } else {
            $this->expandedItems = [];
        }
    }

    private function syncExpandAllState()
    {
        if (empty($this->cotacaoItens['scit'])) {
            $this->expandAll = false;
            return;
        }

        $totalItens = count($this->cotacaoItens['scit']);
        $totalExpandidos = count($this->expandedItems);

        $this->expandAll = ($totalItens === $totalExpandidos);
    }

    public function toggleHistorico($itemId)
    {
        if (isset($this->expandedHistorico[$itemId])) {
            unset($this->expandedHistorico[$itemId]);
        } else {
            $this->expandedHistorico[$itemId] = true;
        }
    }

    public function isHistoricoExpanded($itemId)
    {
        return isset($this->expandedHistorico[$itemId]);
    }

    public function isExpanded($itemId)
    {
        return $this->expandAll || isset($this->expandedItems[$itemId]);
    }

    public function montaArraySelecao($id, $cod, $desc, $qtdSolicitada,
        $unidadeMedida, $codFor, $nomeFor, $valorUnitario, $valorTotal, $acao): void
    {
        $this->indice = $this->indice + 1 ;
        $this->selecionados[$id] = [
            'item' => $id,
            'codProduto'  => $cod,
            'descProduto' => $desc,
            'qtdSolicitada' => $qtdSolicitada,
            'unidadeMedida' => $unidadeMedida,
            'codFor' => $codFor,
            'nomeFor' => $nomeFor,
            'valorUnitario' => $valorUnitario,
            'valorTotal' => $valorTotal,
            'acao'        => $acao
        ];
        $this->enviaOpus = array_merge_recursive($this->observacoes, $this->selecionados);
    }

    public function salvarSelecionados(NewOpusSocketService $opusService)
    {
        $this->msgErro = "";
        $this->retornoOpus = "";
        $userId = Auth::user()?->user;

        if (count($this->cotacaoItens['scit']) - count($this->selecionados) !== 0)
        {
            return $this->msgErro = "É necessário escolher uma ação para todos os itens.";
        }

        if ($this->senhaAprovacao == "")
        {
            return $this->msgErro = "O preenchimento do campo Senha é obrigatório.";
        }
        
        $exportaParametros = [
            'itensSelecionados' => $this->enviaOpus, 
            'senhaAprovador' => $this->senhaAprovacao,
            'filial' => $this->filial,
            'cotacao' => $this->cotacao,
            'usuAprovador' => $this->cotacaoItens['SERAPR'],
        ];

        $this->retornoOpus = $opusService->aprovaRecusaSolicitacaoCompraSuprimento($exportaParametros)['Retorno'];

        if($this->retornoOpus == "Solicitacao Aprovada com Sucesso!"){
            Cache::forget("opus.suprimentos.pendentes.{$userId}");
            Cache::forget("opus.suprimentos.itens.{$this->filial}.{$this->cotacao}.{$userId}");
            $this->js("setTimeout(function() { window.location.replace('".route('Aprova Cotação')."'); }, 3000);");
        }
    }

    public function render()
    {
        return view('Livewire.Suprimentos.AprovaCotacao.ListaItens');
    }
}
