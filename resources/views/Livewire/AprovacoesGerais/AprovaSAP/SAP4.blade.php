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
    <div class="row">
        <div class="d-flex col-12 mb-1">
            <div class="col-sm-2 col-4 div_nome">Favorecimento</div>
            <div class="col-sm-10 col-8 div_campo">{{ $sap['USUAR'] . " - " . $sap['STR30A'] }}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Filial</div>
            <div class="col-8 div_campo">{{$sap['FILIAL'] . " - " . $sap['STR15']}}</div>
        </div>
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-sm-2 col-4 div_nome">Despesa</div>
            <div class="col-sm-10 col-8 div_campo">{{$sap['NUMRDV']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Saida</div>
            <div class="col-8 div_campo">{{$sap['DTSAI']}}</div>
        </div>
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-sm-2 col-4 div_nome">Status</div>
            <div class="col-sm-10 col-8 div_campo">{{$sap['DESSTS']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-4 div_nome">Chegada</div>
            <div class="col-8 div_campo">{{$sap['DTCHEG']}}</div>
        </div>
        <div class="d-flex col-sm-6 mb-1">
            <div class="col-sm-2 col-4 div_nome">Valor adiantado</div>
            <div class="col-sm-10 col-8 div_campo">{{$sap['VLRADIAN']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-12 mb-1">
            <div class="col-2 div_nome">Destino</div>
            <div class="col-10 div_campo">{{$sap['DESTVIA']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-12 mb-1">
            <div class="col-sm-2 col-4 div_nome">Total a Pagar</div>
            <div class="col-sm-10 col-8 div_campo">{{format_currency_br($sap['VLRREST'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-12 mb-1">
            <div class="col-sm-2 col-4 div_nome">Total a Receber</div>
            <div class="col-sm-10 col-8 div_campo">{{format_currency_br($sap['VLRRECEB'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-12 mb-1">
            <div class="col-sm-2 col-4 div_nome">Total Despesa</div>
            <div class="col-sm-10 col-8 div_campo">{{format_currency_br($sap['TOTDESP'])}}</div>
        </div>
    </div>
</div>