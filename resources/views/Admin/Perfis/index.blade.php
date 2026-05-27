@extends('index-modules')

@section('breadcrumb')
    @include('Admin/breadcrumb')
@endsection

@section('aside')
    @include('Admin.aside')
@endsection

@section('title', 'Opus Web - Administração de Usuários')

@section('content')

    <div>
        @if(session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif

        @can('admin.users.index')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Lista de Perfis</h3>
                                <a class="btn btn-success" href="{{ route('perfis.create') }}"><i class="bi bi-plus"></i> Adicionar</a>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <form method="GET">
                                    <select name="filter[perfil_ativo]" onchange="this.form.submit()">
                                        <option value="1" {{ request('filter.perfil_ativo') == '1' ? 'selected' : '' }}>
                                            Ativos (padrão)
                                        </option>
                                        <option value="todos" {{ request('filter.perfil_ativo') == 'todos' ? 'selected' : '' }}>
                                            Todos
                                        </option>
                                        <option value="0" {{ request('filter.perfil_ativo') == '0' ? 'selected' : '' }}>
                                            Inativos
                                        </option>
                                    </select>
                                </form>
                            </div>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-1">ID</th>
                                        <th class="col-6">Perfil</th>
                                        <th class="col-3">Modulos</th>
                                        <th class="col-1">Ativo</th>
                                        <th class="col-1">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perfis as $perfil)
                                        <tr>
                                            <td>{{ $perfil->role_id }}</td>
                                            <td>{{ $perfil->role_name }}</td>
                                            <td>{{ $perfil->modulo }}</td>
                                            <td>
                                                @if ($perfil->ativo == 1)
                                                    <form action="{{ route('Deleta Perfil', [$perfil->role_id, 0]) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="interruptor" onclick="return confirm('Tem certeza que deseja excluir esse perfi? Todos os usuários que estão com ele atribuidos irão passar a ter o usupario padrão.')">
                                                            <div class="icone_area_ativo d-flex justify-end">
                                                                <i class="bi bi-circle-fill icone_100"></i>
                                                            </div>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('Deleta Perfil', [$perfil->role_id, 1]) }}" method="POST" style="display: inline-block;">
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
                                                <a href="{{ route('perfis.edit', $perfil->role_id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> </a>
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
    </div>
@endsection
