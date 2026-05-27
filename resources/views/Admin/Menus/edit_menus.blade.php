@extends('index-modules')

@section('breadcrumb')
    @include('Admin/breadcrumb')
@endsection

@section('aside')
    @include('Admin.aside')
@endsection

@section('title', 'Opus Web - Cricação de Menus')

@section('content')

    <div>
        <div class="row justify-content-between align-items-center">
            <div class="col-3">
                <h3 class="fs-4">EDITA MENU</h3>
            </div>
        </div>

        @can('admin.menus')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-4">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Formulário de Edição de Menus</h3>
                                <a class="btn btn-secondary" href="{{ route('menus') }}"><i class="bi bi-arrow-left"></i> Voltar</a>
                            </div>
                            <form method="POST" action="{{ route('menus.update', $modulos->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3 col-2">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{$modulos->nome}}" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="icone" class="form-label">Icone</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="icone" name="icone" value="{{$modulos->icone}}" required>
                                            </div>
                                            <div class="col-3 caixa_icone">
                                                <i class="bi bi-{{$modulos->icone}}" style="font-size: 40px"></i>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{$modulos->descricao}}" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                    <label for="status" class="form-label">Perfil</label>
                                    <select name="status" id="status" class="form-select">
                                        @if ($modulos->status == 1)
                                            <option value="{{ $modulos->status }}">Ativo</option>
                                            <option value="2">Colocar em Manutenção</option>
                                        @else
                                            <option value="{{ $modulos->status }}">Em Manutenção</option>
                                            <option value="1">Ativo</option>
                                        @endif
                                    </select>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-end mt-3">
                                    <a class="btn btn-danger mr-2" href="{{ route('menus') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
