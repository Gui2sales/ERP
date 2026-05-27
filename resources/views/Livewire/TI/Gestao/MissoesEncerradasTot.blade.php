<div class="card-body table-responsive px-4 py-4 col-lg-12">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="card-title">
            Missões encerradas TOTAIS ({{ $mETOT }})
        </h3>
    </div>
    <hr>

    @if(!$exibeMET)
        <div wire:init="loadExibeMET" class="p-10 text-center text-gray-500">
            <div class="spinner-border" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
            <p>Carregando relatório, aguarde...</p>
        </div>
    @else
        <table class="table table-hover">
            <thead>
                <th>Chamado</th>
                <th>Solicitante</th>
                <th>Descrição</th>
                <th>Sistema</th>
                <th>prioridade</th>
                <th>Colaborador</th>
                <th>Ações</th>
            </thead>
            <tbody>
                @forelse ($missoesEncerradasTOT as $missao)
                    <tr>
                        <td>
                            @if(ctype_digit($missao->chamado ))
                                <a href="https://helpdesk.pacaembuautopecas.com.br/front/ticket.form.php?id={{$missao->chamado }}" 
                                        target="blank"
                                        class="links">
                                        {{ $missao->chamado }}
                                </a>
                            @else
                                {{ $missao->chamado }}
                            @endif
                        </td>
                        <td>{{ $missao->solicitante }}</td>
                        <td>{{ Str::limit( $missao->descricao, 100, ' [...]') }}</td>
                        <td>{{ $missao->sistema }}</td>
                        <td>
                            @php
                                $prioridades = [
                                    1 => 'Super Emergencial',
                                    2 => 'Emergencial', 
                                    3 => 'Urgente',
                                    4 => 'Normal',
                                    5 => 'Baixa',
                                    6 => 'Baixíssima',
                                    7 => 'Sem Prioridade'
                                ];
                            @endphp
                            {{ $prioridades[$missao->prioridade] ?? $missao->prioridade }}
                        </td>
                        <td>{{ $missao->name }}</td>
                        <td>
                            <a href="{{ route('gestao.show', $missao->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> </a>
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

        <div class="mt-4 w-100">
            {{ $missoesEncerradasTOT->links() }} 
        </div>
    @endif
</div>