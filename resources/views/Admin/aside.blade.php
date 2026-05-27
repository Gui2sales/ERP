@canany(['admin'])
    <div class="itens_aside 
        @if(request()->is('administracao/usuarios*')) item_ativo @endif
    ">
        @can('admin.users.index')
            <a class="link opcao_menu" href="{{route("usuarios")}}">
                <i class="bi bi-person-gear"> Usuários </i>
            </a>
        @endcan
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('administracao/perfis*')) item_ativo @endif
    ">
        @can('admin.roles.edit')
            <a class="link opcao_menu" href="{{route("perfis")}}">
                <i class="bi bi-diagram-2"> Perfis </i>
            </a>   
        @endcan
    </div>
    <div class="itens_aside only_pc
        @if(request()->is('administracao/menus*')) item_ativo @endif
    ">
        @can('admin.menus')
            <a class="link opcao_menu" href="{{route("menus")}}">
                <i class="bi bi-boxes"> Menus </i>
            </a>
        @endcan
    </div>
@endcanany