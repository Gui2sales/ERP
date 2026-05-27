<div>
    <div class="fs-3 pt-5 d-flex justify-content-between">
        <div>
            <h3 class="d-inline-block"> Consulta Cotação</h3>
            @if($exibeSCIT)
                <livewire:Components.AtualizadoEm 
                :timestamp="$timestamp">
            @endif
        </div>
        <button wire:click="toggleAll" class="btn btn-primary">
                {{ $expandAll ? 'Recolher Todos' : 'Expandir Todos' }}
            </button>
        
    </div>

    @if(!$exibeSCIT)
        <div wire:init="loadExibeSCIT" class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
            <p>Carregando relatório, aguarde...</p>
        </div>
    @else
        @foreach($cotacaoItens['scit'] as $item)
            <div wire:key="{{ $item['itemSolicitacao'] }}"
                class="my-2 cartao table-responsive p-2
                @isset($selecionados[$item['itemSolicitacao']])
                    @if($selecionados[$item['itemSolicitacao']]['acao'] == "R") bg-red-200 
                    @else bg-green-200
                    @endif
                @else
                    cor_main_2
                @endIsset
            ">
                <div class="container-fluid">
                    <div class="row">
                        <p class="col-9" wire:click="toggleItem('{{ $item['itemSolicitacao'] }}')" style="cursor: pointer;">
                            <span>
                                {{ $this->isExpanded($item['itemSolicitacao']) ? '▼' : '▶' }}
                            </span>
                            <span class="fw-bold">Produto:</span>
                            <span >{{$item['codProduto']}} - {{$item['descProduto']}}</span> 
                        </p>
                        <div class="col-3" @if(!$this->isExpanded($item['itemSolicitacao'])) hidden @endif>
                            <input 
                                type="radio" 
                                name="radio{{$item['itemSolicitacao']}}" 
                                id="radioRecusaTodos{{$item['itemSolicitacao']}}" 
                                autocomplete="off"
                                value="{{ $item['itemSolicitacao'] }}"
                                wire:change="montaArraySelecao
                                    ('{{ $item['itemSolicitacao'] }}'
                                    , '{{ $item['codProduto'] }}'
                                    , '{{ $item['descProduto'] }}'
                                    , '{{ $item['qtdSolicitada'] }}'
                                    , '{{$item['unidadeMedida']}}'
                                    , ''
                                    , ''
                                    , ''
                                    , ''
                                    , 'R'
                                )"
                                class="btn-check"
                            >
                            <label class="btn btn-outline-danger w-100 fonte_branca" 
                                for="radioRecusaTodos{{$item['itemSolicitacao']}}"
                            >Recusar todos</label>
                        </div>
                    </div>
                    <div class="" @if(!$this->isExpanded($item['itemSolicitacao'])) hidden @endif>
                        <livewire:Suprimentos.AprovaCotacao.Observacoes 
                            :observacao="is_array($item['observacao'], ) ? $item['observacao'] : [$item['observacao'] ?? '']" 
                            :item-id="$item['itemSolicitacao']"
                            :key="'obs-' . $item['itemSolicitacao']"                         
                        />
                        @isset($this->observacoes[$item['itemSolicitacao']])
                            <span class="comentado"><i class="bi bi-check2-circle"></i></span>
                        @endisset
                        <div class="container-fluid">
                            <div class="row">
                                <p class="col-md-3">
                                    <span class="fw-bold">Filial :</span>
                                    <span>{{$item['filial']}} {{$item['nomeFilial']}}</span>
                                </p>
                                <p class="col-7">
                                    <span class="fw-bold">Solicitante:</span>
                                    <span>{{$item['codUsuario']}} {{$item['nomeUsuario']}}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-md-3">
                                    <span class="fw-bold">Item da Solicitacao:</span>
                                    <span>{{$item['itemSolicitacao']}}</span>
                                </p>
                                <p class="col-md-3">
                                    <span class="fw-bold">Quantidade Solicitada:</span>
                                    <span>{{$item['qtdSolicitada']}} {{$item['unidadeMedida']}}</span>
                                </p>
                                <p class="col-md-6">
                                    <span class="fw-bold">Marca Principal :</span>
                                    <span>{{$item['marcaPrincipal']}}</span>
                                </p>
                            </div>
                        </div>
                        <table class="table table-hover table-sm shadow mt-2">
                            <thead>
                                <tr>
                                    <th>Fornecedor</th>
                                    <th class="col">Qtd</th>
                                    <th>Marca Cotada</th>
                                    <th class="col-1">Valor Unitario</th>
                                    <th class="col-1">Valor Total</th>
                                    <th class="col-1 only_pc2">Valor Unidade</th>
                                    <th class="col">Prazo Pagamento</th>
                                    <th class="col">Prazo Entrega</th>
                                    <th>Faturamento Minimo</th>
                                    <th>Frete Minimo</th>
                                    <th class="col"></th>
                                    <th>Aprovar</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach($item['fornecedores'] as $itemFornecedor)
                                    <tr @if($itemFornecedor['melhorPreco'] == 'true') class="table-info " @endif>                                    
                                        <td><livewire:Components.Fornecedor 
                                            wire:key="{{ $item['itemSolicitacao'] }}-{{ $itemFornecedor['codigo'] }}"
                                            :codfor="$itemFornecedor['codigo']"
                                            :nome="$itemFornecedor['fornecedorNome']"    
                                        ></td>
                                        <td>{{$itemFornecedor['qtd']}} {{$itemFornecedor['unidadeMedida']}}</td>
                                        <td>{{$itemFornecedor['marcaCotada']}}</td>
                                        <td>{{format_currency_br($itemFornecedor['valorUnitario'])}}</td>
                                        <td>{{format_currency_br($itemFornecedor['valorTotal'])}}</td>
                                        <td class="only_pc2">{{format_currency_br($itemFornecedor['valorUnidade'])}}</td>
                                        <td>{{$itemFornecedor['prazoPagamento']}}</td>
                                        <td>{{$itemFornecedor['prazoEntrega']}}</td>
                                        <td>{{$itemFornecedor['fatMin']}}</td>
                                        <td>{{$itemFornecedor['freteMin']}}</td>
                                        <td>
                                            @isset($itemFornecedor['usuarioAprovador'])
                                                <div class="fornecedores_escolhidos">
                                                    @foreach($itemFornecedor['nomeUsuario'] as $usuAPR)
                                                            <i class="bi bi-check-circle-fill icone_escolhido" title="{{$usuAPR}}"></i>
                                                    @endforeach
                                                </div>
                                            @endisset
                                        </td>
                                        <td>
                                            <div>
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="radio{{$item['itemSolicitacao']}}" 
                                                    id="radio{{$itemFornecedor['codigo']}}"
                                                    wire:change="montaArraySelecao
                                                        ('{{ $item['itemSolicitacao'] }}'
                                                        , '{{ $item['codProduto'] }}'
                                                        , '{{ $item['descProduto'] }}'
                                                        , '{{ $item['qtdSolicitada'] }}'
                                                        , '{{ $item['unidadeMedida'] }}'
                                                        , '{{ $itemFornecedor['codigo'] }}'
                                                        , '{{ $itemFornecedor['fornecedorNome']}}'
                                                        , '{{ $itemFornecedor['valorUnitario'] }}'
                                                        , '{{ $itemFornecedor['valorTotal'] }}'
                                                        , 'A'
                                                    )"
                                                >
                                                <label class="form-check-label" for="radio{{$itemFornecedor['codigo']}}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cartao rounded-md my-3">
                            <div class="fw-bold d-block inline-block container-fluid p-3" 
                                wire:click="toggleHistorico('{{ $item['codProduto'] }}')" 
                                style="cursor: pointer;"
                            >
                                <span>Historico - Ultimas 5 compras</span>
                                <span>
                                    {{ $this->isHistoricoExpanded($item['codProduto']) ? '▼' : '▶' }}
                                </span>
                            </div>
                            <div class="px-2" @if(!$this->isHistoricoExpanded($item['codProduto'])) hidden @endif>
                                <table class="table table-striped shadow table-sm">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Filial</th>
                                            <th>Pedido</th>
                                            <th>Item</th>
                                            <th>Fornecedor</th>
                                            <th>Quantidade</th>
                                            <th>Valor Unitario</th>
                                            <th>Valor Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($item['historicos'])
                                            @foreach($item['historicos'] as $historico)
                                                <tr>
                                                    <td>{{$historico['data']}}</td>
                                                    <td>{{$historico['filial']}} {{$historico['nomeFilial']}}</td>
                                                    <td>{{$historico['pedido']}}</td>
                                                    <td>{{$historico['item']}}</td>
                                                    <td><livewire:Components.Fornecedor
                                                        wire:key="{{ $historico['item'] }}-{{ $historico['codFornecedor'] }}"
                                                        :codfor="$historico['codFornecedor']"
                                                        :nome="$historico['nomeFornecedor']"    
                                                    ></td>
                                                    <td>{{$historico['quantidade']}}</td>
                                                    <td>{{format_currency_br($historico['valorUnitario'])}}</td>
                                                    <td>{{format_currency_br($historico['valorTotal'])}}</td>
                                                    <td> <i class="bi bi-eye btn btn-primary btn-sm"> </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">
                                                    Esse item não possui histórico de compra.
                                                </td>
                                            </tr> 
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="cartao table-responsive rounded-md my-3">
            <div class="bg-pink inline-block container-fluid">
                <div class="row mt-2">
                    <h4>Resumo:</h4>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Fornecedor</th>
                            <th>Valor Unitario</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selecionados as $item)
                            <tr class=" @if($item['acao'] == "R") table-danger @else table-success @endif">
                                <td>{{ $item['item'] }}</td>
                                <td>{{ $item['codProduto'] }} - {{ $item['descProduto'] }}</td>
                                <td>{{ $item['qtdSolicitada'] }} {{ $item['unidadeMedida'] }}</td>
                                @if ($item['acao']  == "R")
                                    <td colspan="3" class="text-center"> RECUSADO</td>
                                @else
                                    <td>{{ $item['codFor'] }} - {{ $item['nomeFor'] }}</td>
                                    <td>{{ format_currency_br($item['valorUnitario']) }}</td>
                                    <td>{{ format_currency_br($item['valorTotal']) }}</td>
                                @endif
                            </tr>                              
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Selecione fornecedores ou recuse os itens para que apareçam aqui.
                                </td>
                            </tr> 
                        @endforelse
                    </tbody>
                </table>
            </div>                       
        </div>
        <div class="cartao rounded-md my-3 container-fluid">
            <form wire:submit="salvarSelecionados">
                <div class="row justify-content-end my-2 mr-1">
                    <h4 class="col-sm-1 mt-2 ml-5">Finalizar</h4>
                    <div class="col-sm-7">
                        <span
                            @if($retornoOpus == "Solicitacao Aprovada com Sucesso!")
                                class="text-success"
                            @else
                                class="text-danger"
                            @endif
                        >{{$msgErro}} {{$retornoOpus}} </span> 
                    </div>
                    <div class="col-md-4 row mt-2">
                        <div class="col-7">
                            <input type="password" wire:model="senhaAprovacao" class="form-control" placeholder="Senha aprovação">
                        </div>
                        <button type="submit" class="btn btn-primary col-5">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>