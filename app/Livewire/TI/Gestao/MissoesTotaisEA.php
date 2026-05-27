<?php

namespace App\Livewire\TI\Gestao;

use App\Models\TI;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MissoesTotaisEA extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $missoesTot = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadMissoesTot()
    {        
        $this->missoesTot = true;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {        
        $query = TI::where('dn_solvers_users', 'like', '%ti0%')
            ->where(function ($q) {
                $q->where('closedate', null)
                  ->where('solvedate', null);
            })
            ->whereNotIn('status', [6, 7, 8, 9, 10, 11])
            ->where('is_deleted', 0)
            ->where(function ($q) {
                $q->where('id', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', "%{$this->search}%")
                  ->orWhere('dn_solvers_users', 'like', "%{$this->search}%");
            })
            ->orderBY($this->sortField, $this->sortDirection);
            
        $paginator = $query->paginate(10);

        $totalSegundos = DB::table('time_track_missoes as ts')
            ->selectRaw('
                ts.chamado_id,
                SUM(
                    TIMESTAMPDIFF(
                        SECOND,
                        ts.start,
                        CASE 
                            WHEN ts.stop IS NULL THEN CURRENT_TIMESTAMP 
                            ELSE ts.stop 
                        END
                    )
                ) as total_segundos
            ')
            ->where('stop', null)
            ->groupBy('ts.chamado_id');

        $missaoAtualAssociativa = $totalSegundos->get()
            ->pluck('total_segundos', 'chamado_id')
            ->toArray();

        $paginator->getCollection()->transform(function ($item) use ($missaoAtualAssociativa) {
            $item->time_track = $missaoAtualAssociativa[$item->id] ?? 'inativa';
            return $item;
        });

        return view('Livewire.TI.Gestao.MissoesTotaisEA', compact('paginator'));
    }
}
