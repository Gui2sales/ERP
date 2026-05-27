@extends('index-modules')

@section('breadcrumb')
    @include('Dho.breadcrumb')
@endsection

@section('aside')
    @include('Dho.aside')
@endsection

@section('title', 'Opus Web - Desenvolvimento Humano')

@section('content')

    <h3 class="fs-3">Banco de talentos</h3>

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
                            <a class="btn btn-success" href="{{ route('bancodetalentos.create') }}"><i class="bi bi-plus"></i> Adicionar</a>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Cargo de Interesse</th>
                                    <th>Recrutador</th>
                                    <th>Fase do processo</th>
                                    <th>LinkedIn</th>
                                    <th>Ver Mais...</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidatos as $candidato)
                                    @if (
                                            $candidato->flag_sigilo == 1 
                                            && $candidato->recrutador == $usuario 
                                            || $candidato->flag_sigilo == 0
                                            || $candidato->recrutador == '01'
                                        )
                                        <tr>
                                            <td class="col-2 align-items-center">
                                                @if($candidato->flag_sigilo == 1)
                                                    <i class="bi bi-circle-fill ponto_aviso" data-toggle="tooltip" title="Usuário com restrição de visibilidade."></i>
                                                @endif
                                                {{ $candidato->nome }}</td>
                                            <td class="col-1 align-items-center">{{ $candidato->numero }}</td>
                                            <td class="col-2 align-items-center">{{ $candidato->cargo_de_interesse }}</td>
                                            <td class="col-2 align-items-center">{{ $candidato->name }}</td>
                                            <td class="col-2 align-items-center">{{ $candidato->fase_processo }}</td>
                                            <td class="col-2 align-items-center">{{ $candidato->linkedin }}</td>
                                            <th class="align-items-center pt-3"> <a href="{{ route('bancodetalentos.show', $candidato) }}"> <i class="bi bi-eye icone_vizualizar ml-2"></i></a> </th>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush