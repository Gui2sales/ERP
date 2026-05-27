@extends('index-modules')

@section('aside')
    @include('TI.aside')
@endsection

@section('title', 'Opus Web - Criação missão')

@section('content')

    <div>
        @can('admin.roles.create')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Criar missão</h3>
                                <a class="btn btn-secondary" href="{{ route('gestao') }}"><i class="bi bi-arrow-left"></i> Voltar</a>
                            </div>
                            <form method="POST" action="{{ route('gestao.store') }}">
                                @csrf
                                <div class="mb-3 col-4">
                                    <label for="titulo" class="form-label">Título do Chamado</label> <span class="campo_obrigatorio"> *</span>
                                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="descricao" class="form-label">Descrição</label> <span class="campo_obrigatorio"> *</span>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                                </div>                                

                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label for="colaborador" class="form-label">Colaborador</label> <span class="campo_obrigatorio"> *</span>
                                        <select name="colaborador" id="colaborador" class="form-select">
                                            @foreach ($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-4">
                                        <label for="tipo" class="form-label">Tipo</label> <span class="campo_obrigatorio"> *</span>
                                        <select name="tipo" id="tipo" class="form-select">
                                            <option value="1">Nova Requisição</option>
                                            <option value="2">Melhoria</option>
                                            <option value="3">BUG</option>
                                            <option value="4">Governo</option>
                                            <option value="5">Ajuste</option>
                                            <option value="6">Projeto</option>
                                            <option value="7">Investigação</option>
                                            <option value="7">Levantamento de Rquisitos</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="mb-3 col-3">
                                        <label for="prioridade" class="form-label">Prioridade</label> <span class="campo_obrigatorio"> *</span>
                                        <select name="prioridade" id="prioridade" class="form-select">
                                            <option value="1">Super Emergêncial</option>
                                            <option value="2">Emergêncial</option>
                                            <option value="3">Urgente</option>
                                            <option value="4">Normal</option>
                                            <option value="5">Baixa</option>
                                            <option value="6">Baixíssima</option>
                                            <option value="7">Sem Prioridade</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-3">
                                        <label for="vencimento" class="form-label">Vencimento</label>
                                        <input type="date" class="form-control" name="vencimento" id="vencimento">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-3">
                                        <label for="area" class="form-label">Área</label> <span class="campo_obrigatorio"> *</span>
                                        <select name="area" id="area" class="form-select">
                                            @foreach ($areas as $area)
                                                <option value="{{$area->id}}">{{$area->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-3">
                                        <label for="sistema" class="form-label">Sistema</label> <span class="campo_obrigatorio"> *</span>
                                        <select name="sistema" id="sistema" class="form-select">
                                            <option value="OPUS">OPUS</option>
                                            <option value="GLPI">GLPI</option>
                                            <option value="Portal - Clientes">Portal - Clientes</option>
                                            <option value="Portal - Fornecedores">Portal - Fornecedores</option>
                                            <option value="Rota Premiada">Rota Premiada</option>
                                            <option value="E-Commerce">E-Commerce</option>
                                            <option value="Intranet">Intranet</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-3">
                                        <label for="status" class="form-label">Status</label> <span class="campo_obrigatorio"> *</span>
                                        <select name="status" id="status" class="form-select">
                                            <option value="0">Aguradando Autorização</option>
                                            <option value="1">Aguradando Janela</option>
                                            <option value="2">Retronado ao N1</option>
                                            <option value="3">Expirado</option>
                                            <option value="4">Em Atendimento</option>
                                            <option value="5">Em Homologação</option>
                                            <option value="6">Entregue</option>
                                            <option value="7">Subistituído</option>
                                            <option value="8">Pausado por 3os</option>
                                            <option value="9">Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <hr>

                                <br>

                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-danger mr-2" href="{{ route('gestao') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Criar MIssão</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection