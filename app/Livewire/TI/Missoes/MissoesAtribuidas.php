<?php

namespace App\Livewire\TI\Missoes;

use App\Models\TI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MissoesAtribuidas extends Component
{
    use WithPagination;
    
    public $queryMissoesPU = [];
    public $emAbertoPU = 0;
    public $missoesAtb = false;

    public function loadMissoesAtb()
    {
        $email = Auth::user()->email;
        $usuario = Auth::id();

        $missoesPU = TI::selectRaw("
                id as chamado
                , dn_solvers_users
                , dn_requesters_users
                , id as colaborador
                , content as descricao
                , dn_category_name
                , priority as prioridade"
            )
            ->where('dn_solvers_users','like','%'.$email.'%')
            ->where('solvedate', null)
            ->where('is_deleted', 0)
            ->get();

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

        $missaoAtualQuery = DB::table('time_track_missoes as tt')
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
            ->where('tt.stop', '=', null);

        $missaoAtualAssociativa = $missaoAtualQuery->get()
            ->pluck('start', 'chamado')
            ->toArray();

        $this->queryMissoesPU = $missoesPU->map(function ($item) use ($missaoAtualAssociativa) {
            $item->status = $missaoAtualAssociativa[$item->chamado] ?? 'inativa';
            return $item;
        })->toArray();

        $this->emAbertoPU = TI::where('closedate',null)
            ->whereNotIn('status',[5,6,7,8,9])
            ->where('dn_solvers_users','like','%'.$email.'%')
            ->where('is_deleted', 0)
            ->count();

        $this->missoesAtb = true;
    }

    public function render()
    {
        return <<<'HTML'
        <div class="card-body table-responsive px-4 py-4 col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="card-title">Missões Atribuidas Em Aberto ( {{ $emAbertoPU }} )</h3>
            </div>
            <hr>
            @if(!$missoesAtb)
                <div wire:init="loadMissoesAtb" class="p-10 text-center text-gray-500">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Gerando relatório, aguarde...</p>
                </div>
            @else
                <table class="table table-hover">
                    <thead>
                        <th></th>
                        <th>Chamado</th>
                        <th>Solicitante</th>
                        <th>Descrição</th>
                        <th>Arvore</th>
                        <th>prioridade</th>
                        <th>Ativa</th>
                    </thead>
                    <tbody>
                        @forelse ($queryMissoesPU as $missao)
                            <tr class="missao_ativa">
                                <td>
                                    <button type="submit" class="btn area_botao_encerra" data-bs-toggle="modal" data-bs-target="#{{$missao['chamado']}}">
                                        <i class="bi bi-check2-square encerrar_chamado"></i>
                                    </button>
                                </td>
                                <td>
                                    @if(ctype_digit($missao['chamado'] ))
                                        <a href="https://helpdesk.pacaembuautopecas.com.br/front/ticket.form.php?id={{$missao['chamado'] }}" 
                                            target="blank"
                                            class="links">
                                            {{ $missao['chamado'] }}
                                        </a>
                                    @else
                                        {{ $missao['chamado'] }}
                                    @endif
                                </td>
                                <td>{{ $missao['dn_requesters_users'][0]['fullname']}}</td>
                                <td>{{ Str::limit( strip_tags(html_entity_decode($missao['descricao'], ENT_QUOTES, 'UTF-8')), 100, ' [...]') }}</td>
                                <td>{{ $missao['dn_category_name']}}</td>
                                <td>
                                    @if( $missao['prioridade'] == 1) Super Emergêncial
                                    @elseif( $missao['prioridade'] == 2) Emergêncial
                                    @elseif( $missao['prioridade'] == 3) Urgente
                                    @elseif( $missao['prioridade'] == 4) Normal
                                    @elseif( $missao['prioridade'] == 5) Baixa
                                    @elseif( $missao['prioridade'] == 6) Baixíssima
                                    @elseif( $missao['prioridade'] == 7) Sem Prioridade
                                    {{$missao['prioridade']}}
                                    @endif
                                </td>
                                <td>
                                    @if ($missao['status'] != 'inativa')
                                        <form action="{{ route('missoes.destroy', [$missao['chamado'], auth()->user()->id, 0]) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="interruptor">
                                                <div class="icone_area_ativo d-flex justify-end">
                                                    <i class="bi bi-circle-fill icone_100"></i>
                                                </div>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('missoes.destroy', [$missao['chamado'], auth()->user()->id, 1]) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="interruptor">
                                                <div class="icone_area d-flex justify-start">
                                                    <i class="bi bi-circle-fill icone_0"></i>
                                                </div>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @include('TI.Missoes.modal', $missao)
                        @empty
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="4">
                                    Não á missões encerradas para exibir.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        HTML;
    }
}
