<?php

namespace App\Livewire\Suprimentos\AprovaCotacao;

use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListaCotacao extends Component
{
    public $exibeSC = false;
    public $cotacoes = [];
    public $timestamp;
    protected NewOpusSocketService $opusService;
    
    public function loadExibeSC(NewOpusSocketService $opusService) 
    {
        $userId = Auth::user()?->user;
        $this->cotacoes = $opusService->getSolicitacaoCompraSuprimentosPendente();
        
        $cacheKey = "opus.suprimentos.pendentes.{$userId}";
        $this->timestamp = DB::table('cache')->select('expiration')->where('key', '=', $cacheKey)->first()->expiration;
        $this->timestamp = $this->timestamp - 300;

        $this->exibeSC = true;
    }

    public function render()
    {
        return view('Livewire.Suprimentos.AprovaCotacao.ListaCotacao');
    }
}
