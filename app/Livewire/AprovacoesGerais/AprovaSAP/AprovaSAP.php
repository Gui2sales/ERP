<?php

namespace App\Livewire\AprovacoesGerais\AprovaSAP;

use App\Services\Logger;
use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AprovaSAP extends Component
{
    public string $numero;
    public string $rota;
    public string $sequencia;
    public string $retornoOpus = "";

    public $exibeSAP = false;
    public $sap = [];
    public $msgErro = "";
    public $senhaAprovacao = "";
    public $acao = "";

    public $motivos = [];
    public $motivo = "";
    public $observacao = "";
    public bool $exibeObservacao = false;

    public $lancamentos = false;
    public $relatorioReembolso = false;
    public $userId;

    public $erro = "";

    public function mount()
    {
        $this->userId = Auth::user();

        Logger::logWithCooldown(
            event: 'pageload',
            properties: ['opus_id' => 'getSap'],
            seconds: 120,
            logName: 'aprovaSap',
            status : 'success',
            description: 'aprovacoesGerais/sap/ubd/'
        );
    }

    public function loadExibeSAP(NewOpusSocketService $opusService) 
    {
        $this->sap = $opusService->getSap($this->numero, $this->rota, $this->sequencia);
        // dd($this->sap);
        Logger::logWithCooldown(
            event: 'getSap',
            properties: [
                'ip'        => request()->ip(),
                'retorno'   => $this->sap
            ],
            seconds: 120,
            logName: 'aprovaSap.funcao:loadExibeSAP',
            status: 'success',
            description: 'aprovacoesGerais/sap/ubd/'
        );

        $this->exibeSAP = true;

        if($this->sap['Retorno'] == "SAP nao encontrada"){
            $this->error('3000');
            return $this->erro = "SAP não encontrada!";
        }
        elseif($this->sap['Retorno'] == "Voce ja aprovou a SAP!"){
            $this->error('3000');
            return $this->erro = "Você já aprovou essa SAP!";
        }elseif($this->sap['Retorno'] == "Voce ja recusou a SAP!"){
            $this->error('3000');
            return $this->erro = "Você já recusou essa SAP!";
        }
    }

    public function aprovaRecusa(NewOpusSocketService $opusService)
    {
        if ($this->senhaAprovacao == ""){
            return $this->msgErro = "O preenchimento do campo Senha é obrigatório.";
        }

        if ($this->acao == "R" && ($this->motivo == "padrao" || $this->motivo == "")){
            return $this->msgErro = "Selecione um motivo válido.";
        }

        if ($this->acao == "padrao" || $this->acao == ""){
            return $this->msgErro = "Selecione o campo de ação corretamente.";
        }

        if ($this->acao == "R" && $this->motivo == "099" && $this->observacao == "")
        {
            return $this->msgErro = "O campo observação é obrigatório para este motivo!";
        }

        $obsFormatado = formata_texto_opus($this->observacao);

        Logger::logWithCooldown(
            event: 'aprovaSap',
            properties: [
                'ip'    => request()->ip(),
                'msg'   => 'Iniciando busca no OPUS.',   
                'variaveis' => [
                    $this->numero
                    , $this->rota
                    , $this->sequencia
                    , $this->acao
                    , $this->motivo
                    , $obsFormatado
                ]
            ],
            seconds: 0,
            logName: 'aprovaSap.funcao:aprovaRecusa',
            status: 'start',
            description: 'aprovacoesGerais/sap/ubd/'
        );

        $aprovacao = $opusService->aprovaSap(
            $this->numero
            , $this->rota
            , $this->sequencia
            , $this->senhaAprovacao
            , $this->acao
            , $this->motivo
            , $obsFormatado
        );
    
        if($aprovacao['RET'] == "Senha invalida"){
            return $this->msgErro = "Senha incorreta!";
        }

        $this->error('');
        Logger::logWithCooldown(
            event: 'aprovaSap',
            properties: [
                'ip'    => request()->ip(),
                'msg'   => 'Concluido',   
                'variaveis' => [
                    $this->numero
                    , $this->rota
                    , $this->sequencia
                    , $this->acao
                    , $this->motivo
                    , $obsFormatado
                ]
            ],
            seconds: 0,
            logName: 'aprovaSap.funcao:aprovaRecusa',
            status: 'success',
            description: 'aprovacoesGerais/sap/ubd/'
        );
        return $this->msgErro = "SAP Aprovada com Sucesso!";
    }

    public function updatedAcao()
    {
        if ($this->acao == "A"){
            $this->motivo = "";
        }
    }

    public function expandeLancamento()
    {
        $this->lancamentos = !$this->lancamentos;
    }

    public function expandeReembolso()
    {
        $this->relatorioReembolso = !$this->relatorioReembolso;
    }

    public function error(string $tempo)
    {
        if($tempo == ""){
            $tempo = '2000';
        }
        Cache::forget("opus.SAP.{$this->userId->user}.{$this->numero}");
        Cache::forget("opus.SAPS.{$this->userId->user}");
        $this->js("setTimeout(function() { window.location.replace('".route('Historico de Compras')."'); }, ".$tempo.");");
    }

    public function render(NewOpusSocketService $opusService)
    {
        $this->motivos = $opusService->getMotivosReprovaSAP();

        return view('Livewire.AprovacoesGerais.AprovaSAP.AprovaSAP');
    }
}
