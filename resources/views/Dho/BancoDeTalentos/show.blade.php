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
                            <h3 class="card-title">{{ $candidato->nome }}</h3>
                            <a class="btn btn-secondary" href="{{ route('Banco de Talentos') }}"><i class="bi bi-arrow-left"></i>  Cancelar</a>
                        </div>
                        
                         <div class="row">
                            <div class="mb-3 col-4">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" readonly value="{{ $candidato->nome }}">
                            </div>
                            <div class="mb-3 col-2">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" readonly value="{{ $candidato->cpf }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="nascimento" class="form-label">Data de nascimento</label>
                                <input type="text" class="form-control" id="nascimento" name="nascimento" readonly value="{{ $candidato->nascimento }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="numero" class="form-label">Número (DDD)</label>
                                <input type="text" class="form-control" id="numero" name="numero" readonly value="{{ $candidato->numero }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-5">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" readonly value="{{ $candidato->email }}">
                            </div>
                            <div class="mb-3 col-7">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="text" class="form-control" id="linkedin" name="linkedin" readonly value="{{ $candidato->linkedin }}">
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="mb-3 col-2">
                                <label for="cep" class="form-label">Cep</label>
                                <input type="text" class="form-control" id="cep" name="cep" readonly value="{{ $candidato->cep }}">
                            </div>
                            <div class="mb-3 col-4">
                                <label for="endereco" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" readonly value="{{ $candidato->endereco }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" readonly value="{{ $candidato->estado }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="municipio" class="form-label">Município</label>
                                <input type="text" class="form-control" id="municipio" name="municipio" readonly value="{{ $candidato->municipio }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" readonly value="{{ $candidato->cidade }}">
                            </div>
                            <div class="mb-3 col-1">
                                <label for="uf" class="form-label">UF</label>
                                <input type="text" class="form-control" id="uf" name="uf" readonly value="{{ $candidato->uf }}">
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="mb-3 col-3">
                                <label for="cargo_de_interesse" class="form-label">Cargo de interesse</label>
                                <input type="text" class="form-control" id="cargo_de_interesse" name="cargo_de_interesse" readonly value="{{ $candidato->cargo_de_interesse }}">
                            </div>                                    
                        </div>
                        <div class="row">
                            <div class="mb-3 col-3">
                                <label for="emprego_atual" class="form-label">Emprego atual</label>
                                <input type="text" class="form-control" id="emprego_atual" name="emprego_atual" readonly value="{{ $candidato->emprego_atual }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="experiencia1" class="form-label">Ultima Experiência</label>
                                <input type="text" class="form-control" id="experiencia1" name="experiencia1" readonly value="{{ $candidato->experiencia1 }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="experiencia2" class="form-label">Demais Experiências</label>
                                <input type="text" class="form-control" id="experiencia2" name="experiencia2" readonly value="{{ $candidato->experiencia2 }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-3">
                                <label for="formacao1" class="form-label">Formação 1</label>
                                <input type="text" class="form-control" id="formacao1" name="formacao1" readonly value="{{ $candidato->formacao1 }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="formacao2" class="form-label">Formação 2</label>
                                <input type="text" class="form-control" id="formacao2" name="formacao2" readonly value="{{ $candidato->formacao2 }}">
                            </div>
                            <div class="mb-3 col-3">
                                <label for="formacao3" class="form-label">Formação 3</label>
                                <input type="text" class="form-control" id="formacao3" name="formacao3" readonly value="{{ $candidato->formacao3 }}">
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="mb-3 col-4">
                                <label for="recrutador" class="form-label">Recrutador</label>
                                <input type="text" class="form-control" id="recrutador" name="recrutador" readonly value="{{ $recrutador->name }}">
                            </div>
                            <div class="form-check col-3 mb-3">
                                <br>
                                <div class="mt-3">
                                    <input name="sigilosa" class="form-check-input" type="checkbox" id="sigilosa" value="1"
                                        @if ($candidato->flag_sigilo == true)
                                            @checked(true)
                                        @endif>
                                    <label class="form-check-label" for="sigilosa"> Vaga Sigilosa</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">   
                            <div class="mb-3 col-4">
                                <label for="capitacao" class="form-label">Origem da Capitação</label>
                                <input type="text" class="form-control" id="capitacao" name="capitacao" readonly value="{{ $candidato->origem_capitacao }}">
                            </div>

                            <div class="mb-3 col-2">
                                <label for="entrevista" class="form-label">Nota da entrevista</label>
                                <input type="text" class="form-control" id="entrevista" name="entrevista" readonly value="{{ $candidato->nota_entrevista }}">
                            </div>

                            <div class="mb-3 col-3">
                                <label for="processo" class="form-label">Fase do processo</label>
                                <input type="text" class="form-control" id="processo" name="processo" readonly value="{{ $candidato->fase_processo }}">
                            </div>
                            
                            <div class="mb-3 col-12">
                                <label for="observacao" class="form-label">Observações</label>
                                <textarea class="form-control" id="observacao" name="observacao" readonly value="{{!! nl2br(e(trim($candidato->obs))) !!}}"></textarea>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <a class="btn btn-danger mr-2" href="{{ route('Banco de Talentos') }}"><i class="bi bi-dash-circle"></i> Sair</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    
@endsection
