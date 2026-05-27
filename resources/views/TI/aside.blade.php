@canany(['ti'])
    <div class="itens_aside
        @if(request()->is('ti')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("ti")}}">
            <i class="bi bi-house"> Menu TI </i>
        </a>
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('ti/chamados*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("chamados")}}">
            <i class="bi bi-clipboard-pulse"> Chamados </i>
        </a>
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('ti/missoes*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("missoes")}}">
            <i class="bi bi-crosshair"> Missões </i>
        </a>
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('ti/gestao*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("gestao")}}">
            <i class="bi bi-clipboard-data"> Gestão </i>
        </a>
    </div>
@endcanany