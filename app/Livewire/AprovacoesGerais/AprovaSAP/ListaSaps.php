<?php

namespace App\Livewire\AprovacoesGerais\AprovaSAP;

use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListaSaps extends Component
{
    public $exibeSAP = false;
    public $saps = [];
    public $timestamp;
    public $userId;
    public $cacheKey;
    
    public function mount()
    {
        $this->userId = Auth::user()?->user;
        if($this->userId == '9972'){
            $this->userId = '9904';
        }

        $this->cacheKey = "opus.SAPS.{$this->userId}";
    }
    public function loadExibeSAP(NewOpusSocketService $opusService) 
    {
        $this->saps = $opusService->getSapPedentes();
        // dd($this->saps);
        
        $this->timestamp = DB::table('cache')->select('expiration')->where('key', '=', $this->cacheKey)->first()->expiration;
        $this->timestamp = $this->timestamp - 300;

        $this->exibeSAP = true;
    }

    public function refresh()
    {
        Cache::forget($this->cacheKey);
        
        return redirect()->route('Historico de Compras');
    }

    public function render()
    {
        return view('Livewire.AprovacoesGerais.AprovaSAP.ListaSaps');
    }
}
