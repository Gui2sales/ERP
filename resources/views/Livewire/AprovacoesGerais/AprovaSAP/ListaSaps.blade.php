<div>
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="d-inline-block">SAP's Pendentes</h3>
            @if($exibeSAP)
                <livewire:Components.AtualizadoEm 
                :timestamp="$timestamp">
            @endif
        </div>
        <div class="d-inline-block">
            @if($exibeSAP)
                <button class="btn btn-primary" wire:click='refresh'><i class="bi bi-arrow-clockwise"></i>Atualizar</button>
            @else
                <button class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i>Atualizar</button>
            @endif
        </div>
    </div>
    
    
    <table class="table table-striped cartao table-bordered my-3">
        <thead>
            <tr>
                <th>SAP</th>
                <th>Vencimento</th>
                <th>Hora</th>
                <th>Fornecedor</th>
                <th>Documento</th>
                <th>Sequencia</th>
                <th>Tipo</th>
                <th>Abrir</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @if(!$exibeSAP)
                <tr wire:init="loadExibeSAP">
                    <td colspan="9" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Carregando...</span>
                        </div>
                        <p>Carregando relatório, aguarde...</p>
                    </td>
                </tr>
            @else
                @isset($saps['sap'])
                    @foreach($saps['sap'] as $sap)
                        <tr>
                            <td>{{$sap['numero']}}</td>
                            <td>{{$sap['primeiroVen']}}</td>
                            <td>{{$sap['hora']}}</td>
                            <td>{{$sap['fornecedor']}}</td>
                            <td>{{$sap['id']}}</td>
                            <td>{{$sap['sequencia']}}</td>
                            <td>{{$sap['fonteDados']}}</td>
                            <td>
                                <a href="{{ route('Aprova SAP',
                                    [
                                        'numero'    => $sap['numero'],
                                        'rota'      => $sap['rota'],
                                        'sequencia' => $sap['sequencia'],
                                    ]) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center"> Nenhuma aprovação pendente encontrada para seu usuário.</td>
                    </tr>
                @endisset
            @endif
        </tbody>
    </table>
</div>
