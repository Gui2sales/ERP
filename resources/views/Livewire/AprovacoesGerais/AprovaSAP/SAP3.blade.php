<div class="cartao container-fluid">
    <div class="row">
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">SAP</div>
            <div class="col-8 div_campo">{{$sap['NUMSAP']}}</div>
        </div>
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Vencimento</div>
            <div class="col-8 div_campo">{{$sap['PRIVEN']}}</div>
        </div>
    </div>
    <div class="d-flex col-12 mb-1">
        <div class="col-4 col-sm-2 div_nome">Favorecido</div>
        <div class="col-8 col-sm-10 div_campo">{{$sap['USUAR'] . " - " . $sap['STR30A']}}</div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Filial</div>
            <div class="col-8 div_campo">{{$sap['FILIAL'] . " - " . $sap['STR15']}}</div>
        </div>
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Reembolso</div>
            <div class="col-8 div_campo">{{$sap['NUMRMB']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Início</div>
            <div class="col-8 div_campo">{{$sap['DATINI']}}</div>
        </div>
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Status</div>
            <div class="col-8 div_campo">{{$sap['DESSTS']}}</div>
        </div>
    </div>
    <div class="d-flex col-12 mb-1">
        <div class="col-4 col-sm-2 div_nome">Término</div>
        <div class="col-8 col-sm-10 div_campo">{{$sap['DATFIM']}}</div>
    </div>
    <div class="d-flex col-12 mb-1">
        <div class="col-4 col-sm-2 div_nome">Total a Pagar</div>
        <div class="col-8 col-sm-10 div_campo">{{format_currency_br($sap['VLREEMB'])}}</div>
    </div>
</div>

<div class="cartao container-fluid mt-3">
    @foreach ( $sap['reembolsoPromotor'] as $rp)
        <div class="row">
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">REEMBOLSO:</span><span class="ml-1"> {{$rp['numReembolso']}}</span>
            </div>
            <div class="d-flex col-6 mb-1">
                <span class="fw-bold">SOLICITANTE:</span><span class="ml-1"> {{$rp['solicitante']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">STATUS:</span><span class="ml-1"> {{$rp['status']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">CPF:</span><span class="ml-1"> {{$rp['cic']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">BANCO:</span><span class="ml-1"> {{$rp['banco']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">AGENCIA:</span><span class="ml-1"> {{$rp['agencia'] . "-" . $rp['codigoAgencia']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">C/C:</span><span class="ml-1"> {{$rp['c/c'] . '-' . $rp['codigoCC']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">FILIAL:</span><span class="ml-1"> {{$rp['filialCod'] . ' ' . $rp['filialNome']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">INÍCIO:</span><span class="ml-1"> {{$rp['inicio']}}</span>
            </div>
            <div class="d-flex col-3 mb-1">
                <span class="fw-bold">TÉRMINO:</span><span class="ml-1"> {{$rp['fim']}}</span>
            </div>
        </div>
    @endforeach
    <div class="btn btn-primary">
        <span wire:click='expandeLancamento'>Lançamentos de Despesas</span>
    </div>
    @if ($lancamentos)
        @forelse ( $sap['documentoDespesa'] as $dp)
            <div class="row mt-2">
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">SEQUENCIA:</span><span class="ml-1"> {{$dp['sequencia']}}</span>
                </div>
                <div class="d-flex col-4 mb-1">
                    <span class="fw-bold">DESPESA:</span><span class="ml-1"> {{$dp['codDesp'] . " " . $dp['descDespesa']}}</span>
                </div>
                @isset($dp['subDescDespesa'])
                    <div class="d-flex col-5 mb-1">
                        <span class="fw-bold">DESCRIÇÃO:</span>
                        <span class="ml-1">{{$dp['subDescDespesa']}}</span>
                    </div>
                @else
                    <div class="d-flex col-5 mb-1"></div>
                @endisset
                <div class="d-flex col-6 mb-1">
                    <span class="fw-bold">DOCUMENTO:</span><span class="ml-1">{{$dp['documento']}}</span>
                </div>
                <div class="d-flex col-6 mb-1">
                    <span class="fw-bold">CNPJ:</span><span class="ml-1"> {{$dp['cnpj']}}</span>
                </div>
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">MODELO:</span><span class="ml-1"> {{$dp['modelo']}}</span>
                </div>
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">NOTA FISCAL:</span><span class="ml-1"> {{$dp['notaFiscal']}}</span>
                </div>
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">FORNECEDOR:</span><span class="ml-1"> {{$dp['fornecedor']}}</span>
                </div>
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">SERIE:</span><span class="ml-1"> {{$dp['ser']}}</span>
                </div>
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">VALOR:</span><span class="ml-1"> {{$dp['valor']}}</span>
                </div>
                <div class="d-flex col-3 mb-1">
                    <span class="fw-bold">REEMBOLSÁVEL?:</span><span class="ml-1"> {{$dp['reembosavel']}}</span>
                </div>
                <div class="d-flex col-6 mb-1">
                    <span class="fw-bold">DATA:</span><span class="ml-1"> {{$dp['data']}}</span>
                </div>
                @isset($dp['veiculo'])
                    <div class="d-flex col-3 mb-1">
                        <span class="fw-bold">PLACA DO VEÍCULO:</span><span class="ml-1"> {{$dp['placa']}}</span>
                    </div>
                    <div class="d-flex col-3 mb-1">
                        <span class="fw-bold">KM:</span><span class="ml-1"> {{$dp['km']}}</span>
                    </div>
                    <div class="d-flex col-6 mb-1">
                        <span class="fw-bold">QUANTIDADE DE LITROS:</span><span class="ml-1"> {{$dp['litros']}}</span>
                    </div>
                    <div class="d-flex col-3 mb-1">
                        <span class="fw-bold">KM PERCORRIDO:</span><span class="ml-1"> {{$dp['kmRodados']}}</span>
                    </div>
                    <div class="d-flex col-9 mb-1">
                        <span class="fw-bold">LITROS POR KM:</span><span class="ml-1"> {{$dp['kmL']}}</span>
                    </div>
                @endisset
                <hr>
            </div>
        @empty
            <div></div>        
        @endforelse
    @endif
    <div class="btn btn-primary">
        <span wire:click='expandeReembolso'>Resumo do Relatório de Reembolso</span>
    </div>
    @if ($relatorioReembolso)
        <div class="row">
            @forelse ($sap['resumoRelatorio'] as $rr)
                <div class="d-flex col-6 mb-1">
                    <span class="fw-bold">{{$rr['dDesp']}}:</span><span class="ml-1">{{ " " . $rr['valorTotal']}}</span>
                </div>
            @empty
                <div></div> 
            @endforelse
            <hr>
            @forelse ($sap['resumoRelatorioSeq'] as $rrs)
                <div class="d-flex col-6 mb-1">
                    <span class="fw-bold">{{$rrs['descricao']}}:</span><span class="ml-1">{{ " " . $rrs['valorTotal']}}</span>
                </div>
            @empty
                <div></div> 
            @endforelse
            <hr>
        </div>
    @endif
    <div class="d-flex col-12 mb-1 mt-2">
        <span class="fw-bold">VALOR TOTAL A PAGAR: {{ " " .  format_currency_br($sap['VLREEMB'])}}</span>
    </div>
</div>


