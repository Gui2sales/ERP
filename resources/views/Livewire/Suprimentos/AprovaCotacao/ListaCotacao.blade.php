<div>
    <h3 class="d-inline-block">Selecione a Solicitação para aprovar</h3>
    @if($exibeSC)
        <livewire:Components.AtualizadoEm 
        :timestamp="$timestamp">
    @endif
    
    <table class="table table-striped cartao table-bordered my-3">
        <thead>
            <tr>
                <th>Filial</th>
                <th>Solicitação</th>
                <th>Descricao</th>
                <th class="only_pc2">Quantidade</th>
                <th>Data</th>
                <th class="only_pc2">Hora</th>
                <th class="only_pc2">Sequencia</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @if(!$exibeSC)
                <tr wire:init="loadExibeSC">
                    <td colspan="9" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Carregando...</span>
                        </div>
                        <p>Carregando relatório, aguarde...</p>
                    </td>
                </tr>
            @else
                @if($cotacoes['quantidadeItensEncontrados'] != 0)
                    @foreach($cotacoes['sc'] as $cotacao)
                        <tr>
                            <td>{{$cotacao['filial']}}</td>
                            <td>{{$cotacao['numero']}}</td>
                            <td>{{$cotacao['descricaoCategoria']}}</td>
                            <td class="only_pc2">{{$cotacao['quantidadeItem']}}</td>
                            <td>{{$cotacao['data']}}</td>
                            <td class="only_pc2">{{$cotacao['hora']}}</td>
                            <td class="only_pc2">{{$cotacao['sequenciaRota']}}</td>
                            <td>
                                <a href="{{ route('AprovaCotação',
                                    [
                                        'filial'  => $cotacao['filial'], 
                                        'cotacao' => $cotacao['numero']
                                    ]) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center"> Nenhuma Cotação Pendente encontrada para seu usuário.</td>
                    </tr>
                @endif
            @endif
        </tbody>
    </table>
</div>
