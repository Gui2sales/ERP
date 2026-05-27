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
                <h3 class="fs-4">Cria Menu</h3>
            </div>
        </div>

        @can('admin.menus')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-4">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Formulário de Criação de Menus</h3>
                                <a class="btn btn-secondary" href="{{ route('menus') }}"><i class="bi bi-arrow-left"></i> Voltar</a>
                            </div>
                            <form method="POST" action="{{ route('menus.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-3">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-3">
                                        <label for="icone" class="form-label">Icone</label>
                                        <input type="text" class="form-control" id="icone" name="icone" required>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="mb-3 col-3">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                                    </div>
                                    <div class="mb-3 col-1">
                                        <label for="sistema" class="form-label">Sistema</label>
                                        <input type="text" class="form-control" id="sistema" name="sistema" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-end mt-3">
                                    <a class="btn btn-danger mr-2" href="{{ route('menus') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Criar Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
