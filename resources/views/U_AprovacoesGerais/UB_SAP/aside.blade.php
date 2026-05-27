@canany(['suprimentos'])
    <div class="itens_aside
        @if(request()->is('aprovacoesGerais/sap')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("SAP")}}">
            <i class="bi bi-house"> SAP </i>
        </a>
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('aprovacoesGerais/sap/ubd*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route('Historico de Compras')}}">
            <i class="bi bi-cart-plus"> Aprova SAP (UBD) </i>
        </a>
    </div>
@endcanany