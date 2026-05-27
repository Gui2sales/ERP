@canany(['dho'])
    <div class="itens_aside
        @if(request()->is('dho')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("dho")}}">
            <i class="bi bi-house"> Menu DHO </i>
        </a>
    </div>
    <div class="itens_aside
        @if(request()->is('dho/bancodetalentos*')) item_ativo @endif
    ">
        <a class="link opcao_menu" href="{{route("Banco de Talentos")}}">
            <i class="bi bi-people"> Banco de Talentos</i>
        </a>
    </div>
@endcanany