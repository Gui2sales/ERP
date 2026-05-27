@extends('index-modules')

@section('aside')
    @include('Admin.aside')
@endsection

@section('title', 'Opus Web - Criação de Usuários')

@section('content')

    <div>
        @can('admin.users.edit')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Formulário de Edição de Usuários</h3>
                                <a class="btn btn-secondary" href="{{ route('usuarios') }}"><i class="bi bi-arrow-left"></i> Voltar</a>
                            </div>
                            <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 col-6">
                                    <div class="row">
                                        <div class="col-10">
                                            <label for="name" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $usuario->name }}" required>
                                        </div>
                                        <div class="col-2 mt-2">
                                            <br>
                                            <input name="ativo" class="form-check-input" type="checkbox" id="inlineCheckbox" 
                                                value="1"
                                                @if ( $usuario->ativo == true)
                                                    @checked(true)
                                                @endif>
                                            <label class="form-check-label" for="ativo">Ativo</label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="mb-3 col-5">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}"required>
                                </div>
                                
                                <div class="mb-3 col-6">
                                    <div class="row">
                                        <div class="mb-3 col-5">
                                            <label for="password" class="form-label">Senha</label>
                                            <input type="text" class="form-control senha_padrao" id="password" name="password" onlyread>
                                        </div>
                                        <div class="col-7 mt-2">
                                            <br>
                                            <button type="button" class="btn btn-primary" id="altera_senha">Redefinir senha</button>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="mb-3 col-3">
                                    <label for="role_id" class="form-label">Perfil</label>
                                    <select name="role_id" id="role_id" class="form-select">
                                        @foreach($perfis as $perfil)
                                            <option value="{{ $perfil->name }}">
                                                {{ $perfil->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row m-0 py-5 px-5 caixa">
                                    @foreach($permissoes as $permissao)
                                        <div class="form-check col-2">
                                            <input name="permissoes[]" class="form-check-input" type="checkbox" id="inlineCheckbox" 
                                                value="{{ $permissao->name }}"
                                                @if ( $permissao->model_id)
                                                    @checked(true)
                                                @endif>
                                            <label class="form-check-label" for="{{ $permissao->name }}">{{ $permissao->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <br>

                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-danger mr-2" href="{{ route('usuarios') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Salvar </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('altera_senha').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        passwordField.readOnly = true;
        passwordField.value = 'Pacaembu2@25';
        passwordField.type = 'text';
        passwordField.classList.remove('senha_padrao');
        passwordField.focus();
    });
</script>
@endpush