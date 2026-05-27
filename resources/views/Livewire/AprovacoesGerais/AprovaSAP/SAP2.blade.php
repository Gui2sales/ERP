<div class="cartao container-fluid">
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">SAP</div>
            <div class="col-8 div_campo">{{$sap['NUMSAP']}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Vencimento</div>
            <div class="col-8 div_campo">{{$sap['PRIVEN']}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">CNPJ</div>
            <div class="col-8 div_campo">{{$sap['CGCFOR']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-8 mb-1">
            <div class="col-2 div_nome">Prestador</div>
            <div class="col-10 div_campo"><livewire:Components.FornecedorServicos
                :codserv="$sap['CODSERV']"
                :nome="$sap['STR15']"    
            ></div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Emissão</div>
            <div class="col-8 div_campo">{{$sap['DATEMIS']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-8 mb-1">
            <div class="col-2 div_nome">Fi/Doc</div>
            <div class="col-10 div_campo">{{$sap['STR30']}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Entrada</div>
            <div class="col-8 div_campo">{{$sap['DATENTR']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Valor da Nota</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTNOF'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Desc</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VALDESC'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Acresc</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VALACR'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base ICMS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBICM'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">ICMS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTICM'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">De.FI</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLDESCO'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base IPI</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBIPI'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">IPI</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTIPI'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base PIS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBPIS'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base ISS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBISS'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">ISS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTISS'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">PIS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTPIS'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base INSS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBINSS'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">INSS</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTINSS'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base CSL</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBCSL'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base CONFI</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBCOF'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">CONFI</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTCOF'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">CSL</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTCSL'])}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base INS2</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBINS2'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">INS2</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTINS2'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">D.Ac</div>
            <div class="col-8 div_campo">{{$sap['VLTDPA']}}</div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Base IRF</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLBIRRF'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">IRRF</div>
            <div class="col-8 div_campo">{{format_currency_br($sap['VLTIRRF'])}}</div>
        </div>
        <div class="d-flex col-sm-4 mb-1">
            <div class="col-4 div_nome">Valor Pgr</div>
            <div class="col-8 div_campo">{{ "R$ " . $sap['TOTAL']}}</div>
        </div>
    </div>
</div>