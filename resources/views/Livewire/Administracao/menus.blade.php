<div>
    <div class="conteiner  mr-2">
        <div class="row d-flex justify-content-center align-items-center mt-5">
            <div class="cartao">
                <div class="card-body table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title mt-2 mr-5">Lista de Módulos</h3>
                            <div>
                                <div wire:loading wire:target="atualizaSMR" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Carregando...</span>
                                </div>
                                <livewire:Components.AtualizadoEm 
                                    wire:loading.remove 
                                    wire:target="atualizaSMR"
                                    :timestamp="$timestamp">
                            </div>
                        </div>
                        <div>
                            @if($bloqueiaBotao == true)
                                <button class="btn btn-secondary"
                                >
                                    <i class="bi bi-arrow-clockwise"></i>
                                    Atualizar
                                </button>
                            @else
                                <button class="btn btn-primary" 
                                    wire:click="atualizaSMR"
                                    wire:loading.attr="disabled" 
                                    wire:target="atualizaSMR"
                                >
                                    <i wire:loading.remove wire:target="atualizaSMR" class="bi bi-arrow-clockwise"></i>
                                    <div wire:loading wire:target="atualizaSMR" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Carregando...</span>
                                    </div>
                                    Atualizar
                                </button>
                            @endif
                            <button class="btn btn-success" wire:click='toggleExibe'><i class="bi bi-plus"></i> Adicionar</button>
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="col-1">ID</th>
                                <th class="col-3">Módulo</th>
                                <th class="col-1">Icone</th>
                                <th class="col-3">Descrição</th>
                                <th class="col-1">Ativo</th>
                                <th class="col-1">Status</th>
                                <th class="col-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulos as $modulo)
                                <tr>
                                    <td>{{ $modulo->id }}</td>
                                    <td>{{ $modulo->nome }}</td>
                                    <td><i class="bi bi-{{ $modulo->icone }}"></i></td>
                                    <td>{{ $modulo->descricao }}</td>
                                    <td>
                                        @if ($modulo->ativo == 1)
                                            <form action="{{ route('Inativa Menu', [$modulo->id, 0]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="interruptor">
                                                    <div class="icone_area_ativo d-flex justify-end">
                                                        <i class="bi bi-circle-fill icone_100"></i>
                                                    </div>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('Inativa Menu', [$modulo->id, 1]) }}" method="POST" style="display: inline-block;">
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
                                    <td>{{ $modulo->status }}</td>
                                    <td>
                                        <a href="{{ route('menus.edit', $modulo->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @if ($exibe)
        <div class="fundo_modal">
            <div class="card_modal container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title">Criação de Menus</h3>
                    <button class="btn" wire:click='toggleExibe'><i class="bi bi-x-lg"></i></a>
                </div>
                <form wire:submit.prevent='criaMenu'>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="sistema" class="form-label">Sistema</label>
                            <input type="text" class="form-control" id="sistema" name="sistema" required wire:model.live='sistema'>
                        </div>
                        <div class="col-6">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" readonly wire:model='nome' value="{{$nome}}">
                        </div>
                    </div>
                    <div class="row mb-5"> 
                        <div class="col-6">
                            <label for="name" class="form-label">Icone</label>
                            <div class="input-group">
                                <span class="input-group-text col-3">bi bi-</span>
                                <input type="text" class="form-control" id="usuario" name="Icone" required wire:model='icone'/>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" wire:model='status'>
                                <option value="1">Ativo</option>
                                <option value="2">Manutenção</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end mt-3 mb-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Criar Menu</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>