@extends('index-modules')

@section('aside')
    @include('Admin.aside')
@endsection

@section('title', 'Opus Web - Cricação de Menus')

@section('content')

    <div>
        <h3 class="mb-0">Edição de Perfis</h3>

        @can('admin.roles.create')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Formulário de Criação de Perfil</h3>
                                <a class="btn btn-secondary" href="{{ route('perfis') }}"><i class="bi bi-arrow-left"></i> Voltar</a>
                            </div>
                            <form method="POST" action="{{ route('perfis.update', $perfis->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 col-5">
                                    <label for="name" class="form-label">Perfil</label>
                                    <input type="text" class="form-control" id="name" value="{{$perfis->name}}" readonly>
                                </div>

                                <hr>

                                <div class="row m-0 py-5 px-5 caixa">
                                    @foreach($permissoes as $permissao)
                                        <div class="form-check col-3">
                                            <input name="permissoes[]" class="form-check-input" type="checkbox" id="inlineCheckbox" 
                                            value="{{ $permissao->name }}"
                                            @if ( $permissao->role_id)
                                                @checked(true)
                                            @endif>
                                            <label class="form-check-label" for="{{ $permissao->name }}">{{ $permissao->name }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <br>

                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-danger mr-2" href="{{ route('perfis') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Alterar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
