@extends('index-modules')

@section('aside')
    @include('TI.aside')
@endsection

@section('title', 'Opus Web - Vizualia missão')

@section('content')

    <div>
        @can('admin.roles.create')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Chamado {{ $chamado->id }}</h3>
                                <a class="btn btn-secondary" href="{{ route('missoes') }}"><i class="bi bi-arrow-left"></i> Voltar</a>
                            </div>
                            
                            <div class="mb-3 col-12">
                                <label for="chamado" class="form-label">Título</label>
                                <input type="text" class="form-control" id="chamado" name="chamado" value="{{$chamado->name}}" readonly>
                            </div>

                            <div class="mb-3 col-12">
                                <label for="solicitante" class="form-label">Solicitante</label>
                                <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{ $chamado['dn_requesters_users'][0]['fullname'] }}" readonly>
                            </div>

                            <div class="mb-3 col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" readonly>{{strip_tags(html_entity_decode($chamado['content'], ENT_QUOTES, 'UTF-8'))}}
                                </textarea>
                            </div>                                

                            <div class="row">
                                <div class="mb-3 col-8">
                                    <label for="colaborador" class="form-label">Colaborador</label>
                                    <input type="text" class="form-control" id="colaborador" name="colaborador" value="{{$usuario}}" readonly>
                                </div>

                                <div class="mb-3 col-4">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" value="{{$tipo}}" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="mb-3 col-3">
                                    <label for="prioridade" class="form-label">Prioridade</label>
                                    <input type="text" class="form-control" id="prioridade" name="prioridade" value="{{$prioridade}}" readonly>
                                </div>

                                <div class="mb-3 col-3">
                                    <label for="vencimento" class="form-label">Encerrado</label>
                                    <input type="text" class="form-control" name="vencimento" id="vencimento" value="{{ $chamado->closedate }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status" value=" {{$status}}" readonly>
                                </div>
                            </div>

                            <hr>

                            <br>

                            <div class="d-flex justify-content-end">
                                <a class="btn btn-danger mr-2" href="{{ route('missoes') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection