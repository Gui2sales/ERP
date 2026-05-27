<?php

namespace App\Livewire\Components;

use App\Models\Modules;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Menus extends Component
{
    public $sistemas;
    public $exibe = true;
    public $expandedItems = [];
    public $pesquisa = "";
    public $modulosFiltrados;
    public $sistema;

    public function mount()
    {
        $this->sistemas = Modules::with(['modulos' => function ($q) {
            $q->where('ativo', 0)
                ->select('sigla_sistema', 'sigla', 'nome')
                ->orderBy('sigla', 'asc');
            }])
            ->where('ativo', 1)
            ->where('status', '<>', 0)
            ->select('id', 'sistema', 'nome', 'icone', 'descricao', 'status')
            ->orderBy('sistema')
            ->get();
    }

    public function atribuiSistema($sistema)
    {
        $this->sistema = $sistema;
    }

    public function updatedPesquisa()
    {
        $this->modulosFiltrados = Modulo::select()
            ->where(function ($query) {
                $query->whereRaw("LOWER(nome) LIKE LOWER(?)", ["%{$this->pesquisa}%"])
                    ->orWhereRaw("sigla LIKE UPPER(?)", ["{$this->pesquisa}%"]);
            })
            ->where('sigla_sistema', '=', $this->sistema)
            ->get();
    }

    public function redireciona($sigla)
    {
        $vaiPara = DB::table('busca_telas_index')
            ->select('ROTA')
            ->where('SIGLA', $sigla)
            ->get()
            ->first();

        return redirect()->route($vaiPara->ROTA);   
    }

    public function toggleItem($itemId)
    {
        if (isset($this->expandedItems[$itemId])) {
            unset($this->expandedItems[$itemId]);
        } else {
            $this->expandedItems = [$itemId => true];
        }
    }

    public function toggleOfItens()
    {
        $this->expandedItems = false;
    }

    public function isExpanded($itemId)
    {
        return isset($this->expandedItems[$itemId]);
    }

    public function render()
    {
        return view('Livewire.Components.menus');
    }
}
