<div class="botoes_menu_modules cor_main_2" wire:click='toggleExibe'>
    <h3> {{$this->moduloAtual[0]->NOME . " (".$modulo.")"}}</h3>
    @if($exibe)
        <div class="caixa_expandida cor_main_2">
            <ul wire:click='toggleExibe'>
                @forelse($telas as $tela)
                    <li class="pl-2">
                        <a href="{{route($tela->ROTA)}}">{{$tela->NOME . " (".$tela->SIGLA.")"}}</a>
                        </li>
                @empty
                    <li>Em desenvolvimento ...</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
