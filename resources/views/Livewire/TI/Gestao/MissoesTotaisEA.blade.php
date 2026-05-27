<div class="card-body table-responsive px-4 py-4 col-lg-12">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="card-title">Missões Atribuidas TOTAIS Em Aberto</h3>
    </div>
    <hr>
    <div class="card-body">
        @if(!$missoesTot)
            <div wire:init="loadMissoesTot" class="p-10 text-center text-gray-500">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Gerando relatório, aguarde...</p>
            </div>
        @else
            <div class="mb-3">
                <input 
                    wire:model.live="search" 
                    type="text"
                    class="form-control"
                    placeholder="Buscar por ID, nome ou solver..."
                >
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 8%" wire:click="sortBy('id')" role="button">
                                ID
                                @if ($sortField === 'id')
                                    <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </th>
                            <th>Requerente</th>
                            <th>Descrição</th>
                            <th wire:click="sortBy('date')" role="button">
                                Data Abertura
                                @if ($sortField === 'date')
                                    <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </th>
                            <th>Responsável</th>
                            <th>Tempo Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paginator as $m)
                            <tr>
                                <td class="col-1">
                                    @if($m['time_track'] != 'inativa')
                                        <i class="bi bi-circle-fill ponto_aviso_verde" data-toggle="tooltip" title="Missão Ativa neste momento."></i>
                                    @endif
                                    @if(ctype_digit($m['id'] ))
                                        <a href="https://helpdesk.pacaembuautopecas.com.br/front/ticket.form.php?id={{ $m['id'] }}" 
                                                target="blank"
                                                class="links">
                                                {{ $m['id'] }}
                                        </a>
                                    @else
                                        {{ $m['id'] }}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($m['dn_requesters_users']) && isset($m['dn_requesters_users'][0]['fullname']))
                                        {{ $m['dn_requesters_users'][0]['fullname'] }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    {{ Str::limit( strip_tags(html_entity_decode($m['content'], ENT_QUOTES, 'UTF-8')), 80, ' [...]') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($m['date'])->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $solvers = $m['dn_solvers_users'] ?? [];
                                        $fullname = null;
                                        if (!empty($solvers)) {
                                            $fullname = ($solvers[1]['fullname'] ?? null) ?: ($solvers[0]['fullname'] ?? null);
                                        }
                                    @endphp
                                    {{ $fullname ?: '—' }}
                                </td>
                                <td>
                                    @php
                                        if ($m['time_track'] != 'inativa') {
                                            $interval = \Carbon\CarbonInterval::seconds($m['time_track']);
                                            $tempo = $interval->cascade()->forHumans(['locale' => 'pt_BR']);
                                        } else {
                                            $tempo = 'inativa';
                                        }
                                    @endphp
                                    {{$tempo}}
                                </td>
                                <td>
                                    <a href="{{ route('gestao.show', $m['id']) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="4">
                                    Não á chamados encerrados para exibir.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $paginator->links() }}
            </div>
        @endif
    </div>
</div>