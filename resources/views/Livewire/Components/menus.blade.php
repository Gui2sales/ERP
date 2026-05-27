<div id="menu_botoes" wire:click.outside='toggleOfItens'>
    @foreach($sistemas as $si)
        @can(strtolower($si->nome))
            @if($si->status <> 1)
                <a href="#" onclick="alert('Módulo em manutenção!'); return false;">
            @elseif($si->status == 1 && $si->modulos->isEmpty())
                <a href="{{route(strtolower($si->nome))}}">
            @endif

            @if($si->modulos->isNotEmpty() && $si->status == 1 && $this->isExpanded($si->id))
                <div class="botoes_menu cor_main_2 div_menus" wire:key="{{ $si->id }}">
                    <ul class="menus">
                        @foreach($si->modulos as $modulo)
                            <li
                                @if($modulo->ativo == 0) class="inativo" @else wire:click="redireciona('{{$modulo->sigla_sistema.$modulo->sigla}}')" @endif
                            >
                                {{ "(" . $modulo->sigla_sistema . $modulo->sigla . ")" ." ". $modulo->nome }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="botoes_menu cor_main_2"
                    wire:click="toggleItem('{{ $si->id }}')"
                    style="
                        background-image: url('{{ asset('images/imagens_botoes/'.$si->nome.'.png') }}')
                        ,linear-gradient(90deg, rgb(115, 158, 250) 25%, rgb(84, 135, 246) 65%,  rgb(40, 115, 240) 95%);
                ">
                    <h1><i class="bi bi-{{$si->icone}} icones_menu"> 
                            @if($si->sistema <> "000")
                                {{"(" . $si->sistema . ")" . $si->descricao}}
                            @else
                                {{$si->descricao}}
                            @endif
                        </i>
                    </h1>
                </div>
            @endif
            </a>
        @endcan
    @endforeach
</div>
