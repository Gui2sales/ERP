<?php

namespace App\Livewire\TI\Missoes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Livewire;

class MissaoAtual extends Component
{

    public $missaoAtual;
    public $missaoAt = false;
    public $missao;
    public function loadMissaoAt ()
    {
        $usuario = Auth::id();

        $totalSegundos = DB::table('time_track_missoes as ts')
                ->selectRaw('
                    ts.usuario_id,
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
        ->groupBy('ts.usuario_id', 'ts.chamado_id');

        $this->missaoAtual = DB::table('time_track_missoes as tt')
                ->selectRaw('
                    tt.usuario_id,
                    tt.chamado_id as chamado,
                    tt.start,
                    tt.stop,
                    total_segundos
                ')
                ->leftJoin(DB::raw("({$totalSegundos->toSql()}) as tt_total"), function ($join) {
                    $join->on('tt_total.usuario_id', '=', 'tt.usuario_id')
                        ->on('tt_total.chamado_id', '=', 'tt.chamado_id');
                })
                ->mergeBindings($totalSegundos)
                ->where('tt.usuario_id', '=', $usuario)
            ->where('tt.stop', '=', null)
        ->first();

        $this->missaoAt = true;
    }

    public function render()
    {
        return view('Livewire.TI.Missoes.MissaoAtual');
    }
}
