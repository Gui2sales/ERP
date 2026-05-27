<div>
    @can('admin.users.index')
        <div class="conteiner mr-2">
            <div class="row d-flex justify-content-center align-items-center mt-5">
                <div class="cartao">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="card-title">Lista de Usuários</h3>
                            <button class="btn btn-success" wire:click='toggleExibe'><i class="bi bi-plus"></i> Adicionar</button>
                        </div>

                        <div class="container-flex mb-4 overflow-hidden">
                            <div class="row">
                                <div class="d-flex col-md-2 col-5 mb-2">
                                    <div class="col-4 div_nome">Status</div>
                                    <select 
                                        name="usuario_ativo" 
                                        wire:model.live='filtroAtivo' 
                                        class="col-8 div_campo_busca">
                                        <option value="1">
                                            Ativos
                                        </option>
                                        <option value="">
                                            Todos
                                        </option>
                                        <option value="0">
                                            Inativos
                                        </option>
                                    </select>
                                </div>
                                <div class="d-flex col-md-2 col-7 mb-2">
                                    <div class="col-3 div_nome">Nome</div>
                                    <input class="col-9 div_campo_busca" type="search" name="usuario" wire:model.live="filtroNome"/>
                                </div>
                                <div class="d-flex col-md-2 col-5 mb-2">
                                    <div class="col-md-5 col-4 div_nome">Usuário</div>
                                    <input class="col-md-7 col-8 div_campo_busca" type="search" name="usuario" wire:model.live="filtroUsuario"/>
                                </div>
                                <div class="d-flex col-md-3 col-7 mb-2">
                                    <div class="col-3 div_nome">E-mail</div>
                                    <input class="col-9 div_campo_busca" type="search" name="usuario" wire:model.live="filtroEmail"/>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-3" wire:click="order('nome')">Nome</th>
                                    <th class="col-2" wire:click="order('user')">Usuário OPUS</th>
                                    <th class="col-3" wire:click="order('email')">E-mail</th>
                                    <th class="col-2" wire:click="order('perfil')">Perfil</th>
                                    <th class="col-1" wire:click="order('status')">Status</th>
                                    <th class="col-1">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->nome_usu }}</td>
                                        <td>{{ $usuario->usuario }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->nome_role }}</td>
                                        <td>
                                            @if ($usuario->ativo == 1)
                                                <form action="{{ route('Inativa Usuario', [$usuario->cod_usu, 0]) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="interruptor">
                                                        <div class="icone_area_ativo d-flex justify-end">
                                                            <i class="bi bi-circle-fill icone_100"></i>
                                                        </div>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('Inativa Usuario', [$usuario->cod_usu, 1]) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="interruptor">
                                                        <div class="icone_area d-flex justify-start">
                                                            <i class="bi bi-circle-fill icone_0"></i>
                                                        </div>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            <livewire:Administracao.UsuarioEdita :usu='$usuario->cod_usu' :key='$usuario->cod_usu'></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @if ($exibe)
        <div class="fundo_modal">
            <div class="card_modal container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title">Criação de Usuários</h3>
                    <button class="btn" wire:click='toggleExibe'><i class="bi bi-x-lg"></i></a>
                </div>
                <form wire:submit.prevent='criaUsuario'>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="user" class="form-label">Usuário Opus</label>
                            <input type="text" class="form-control" id="user" name="user" required wire:model.live='usuario'>
                        </div>
                        @if($toggleBotao)
                            <div class="col-2">
                                <br>
                                <span class="btn btn-primary mt-2" wire:click='buscaUsuario'>Buscar</span>
                            </div>
                        @else
                            <div class="col-5">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" wire:model='nome' value="{{$nome}}">
                            </div>
                            <div class="col-5">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" wire:model='email' value="{{$email}}">
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="mb-3 col-3 mt-3">
                        <label for="role_id" class="form-label">Perfil</label>
                        <select name="role_id" id="role_id" class="form-select" wire:model='perfilSelecionado'>
                            <option value="padrao">Selecionar</option>
                            @foreach($perfis as $perfil)
                                <option value="{{ $perfil->name }}">
                                    {{ $perfil->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row m-0 py-2 px-2 caixa">
                        @foreach($permissoes as $permissao)
                                    <div class="form-check col-3">
                                        <input type="checkbox" 
                                            class="form-check-input"  
                                            id="perm_{{ $permissao->id }}" 
                                            name="inlineCheckbox" 
                                            value="{{ $permissao->name }}"
                                            wire:model='inlineCheckbox'
                                        >
                                        <label class="form-check-label" for="perm_{{ $permissao->id }}">{{ $permissao->name }}</label>
                                    </div>
                                @endforeach
                    </div>
                    <div class="d-flex justify-content-end mt-3 mb-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Criar Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($notifica)
        <livewire:Components.BoxNotificacao lazy :titulo='"Criação de Usuário"'/>
    @endif
</div>
