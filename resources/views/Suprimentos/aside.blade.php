@canany(['suprimentos'])
    <div class="itens_aside
        @if(request()->is('suprimentos/cotacao')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("cotacao")}}">
            <i class="bi bi-house"> Cotação </i>
        </a>
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('suprimentos/cotacao/aprovacotacao*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("Aprova Cotação")}}">
            <i class="bi bi-cart-plus"> Aprova Cotação (VCF) </i>
        </a>
    </div>
    {{-- <div class="itens_aside
        @if(request()->is('suprimentos/historicoCompras*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("Historico de Compras")}}">
            <i class="bi bi-clock-history"> Historico Cotação (VCX) </i>
        </a>
    </div> --}}
@endcanany