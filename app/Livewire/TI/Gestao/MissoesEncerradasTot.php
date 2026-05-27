<?php

namespace App\Livewire\TI\Gestao;

use App\Models\TI;
use Livewire\Component;
use Livewire\WithPagination;

class MissoesEncerradasTot extends Component
{
    use WithPagination;
    
    public $search = '';
    public $exibeMET = false;

    public $mETOT = 0;

    public function updatingSerach()
    {
        $this->resetPage();
    }

    public function loadExibeMET()
    {
        $this->exibeMET = true;
    }    

    public function render()
    {   
        $missoesEncerradasTOT = TI::where(function ($query) {
                $query->where('solvedate','>', '2026-03-01 00:00:00')
                    ->orWhere('closedate','>', '2026-03-01 00:00:00');
            })
            ->where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $this->mETOT = TI::where(function ($query) {
                $query->where('solvedate','>','2026-03-01 00:00:00')
                    ->orWhere('closedate','>','2026-03-01 00:00:00');
            })
            ->where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
            ->where('is_deleted', 0)
            ->count();

        return view('Livewire.TI.Gestao.MissoesEncerradasTot', compact('missoesEncerradasTOT'));
    }
}
