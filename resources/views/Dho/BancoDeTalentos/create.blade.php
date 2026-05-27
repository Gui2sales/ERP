@extends('index-modules')

@section('aside')
    @include('Dho.aside')
@endsection

@section('title', 'Opus Web - Desenvolvimento Humano')

@section('content')
    <div>
        <h3 class="fs-3 mt-5">Banco de talentos</h3>

        @can('admin.users.index')
            <div class="conteiner">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    <div class="cartao">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title">Cadastro de Talento</h3>
                                <a class="btn btn-secondary" href="{{ route('Banco de Talentos') }}"><i class="bi bi-arrow-left"></i>  Cancelar</a>
                            </div>

                            <form method="POST" action="{{ route('bancodetalentos.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label for="nome" class="form-label">Nome</label><span class="campo_obrigatorio"> *</span>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                    <div class="mb-3 col-2">
                                        <label for="cpf" class="form-label">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="nascimento" class="form-label">Data de nascimento</label>
                                        <input type="text" class="form-control" id="nascimento" name="nascimento">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="numero" class="form-label">Número (DDD)</label><span class="campo_obrigatorio"> *</span>
                                        <input type="text" class="form-control" id="numero" name="numero" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="mb-3 col-5">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="mb-3 col-7">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" id="linkedin" name="linkedin">
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-3 mb-3">
                                    <div class="mb-3 col-2">
                                        <label for="cep" class="form-label">Cep</label>
                                        <input type="text" class="form-control" id="cep" name="cep">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="endereco" class="form-label">Endereço</label>
                                        <input type="text" class="form-control" id="endereco" name="endereco">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <input type="text" class="form-control" id="estado" name="estado">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="municipio" class="form-label">Município</label>
                                        <input type="text" class="form-control" id="municipio" name="municipio">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="cidade" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade">
                                    </div>
                                    <div class="mb-3 col-1">
                                        <label for="uf" class="form-label">UF</label>
                                        <input type="text" class="form-control" id="uf" name="uf">
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-3 mb-3">
                                    <div class="mb-3 col-3">
                                        <label for="cargo_de_interesse" class="form-label">Cargo de interesse</label>
                                        <input type="text" class="form-control" id="cargo_de_interesse" name="cargo_de_interesse">
                                    </div>                                    
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="mb-3 col-3">
                                        <label for="emprego_atual" class="form-label">Emprego atual</label>
                                        <input type="text" class="form-control" id="emprego_atual" name="emprego_atual">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="experiencia1" class="form-label">Ultima Experiência</label>
                                        <input type="text" class="form-control" id="experiencia1" name="experiencia1">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="experiencia2" class="form-label">Demais Experiências</label>
                                        <input type="text" class="form-control" id="experiencia2" name="experiencia2">
                                    </div>
                                </div>

                                <div class="row mt-3 mb-3">
                                    <div class="mb-3 col-3">
                                        <label for="formacao1" class="form-label">Formação 1</label>
                                        <input type="text" class="form-control" id="formacao1" name="formacao1">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="formacao2" class="form-label">Formação 2</label>
                                        <input type="text" class="form-control" id="formacao2" name="formacao2">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="formacao3" class="form-label">Formação 3</label>
                                        <input type="text" class="form-control" id="formacao3" name="formacao3">
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-3">   
                                    <div class="mb-3 col-4">
                                        <label for="capitacao" class="form-label">Origem da Capitação</label><span class="campo_obrigatorio"> *</span>
                                        <input type="text" class="form-control" id="capitacao" name="capitacao">
                                    </div>

                                    <div class="mb-3 col-2">
                                        <label for="entrevista" class="form-label">Nota da entrevista</label>
                                        
                                        <select name="entrevista" id="entrevista" class="form-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3 col-3">
                                        <label for="processo" class="form-label">Fase do processo</label>
                                        
                                        <select name="processo" id="processo" class="form-select">
                                            <option value="entrevista">Entrevista</option>
                                            <option value="triagem">Triagem</option>
                                            <option value="agendamento">Agendamento</option>
                                            <option value="teste">Teste</option>
                                            <option value="reprovacao">Reprovação da Gestão</option>
                                            <option value="desistencia">Desistência</option>
                                        </select>
                                    </div>

                                    <div class="form-check col-3 mb-3">
                                        <br>
                                        <div class="mt-3">
                                            <input name="sigilosa" class="form-check-input" type="checkbox" id="sigilosa" value="1">
                                            <label class="form-check-label" for="sigilosa">Vaga Sigilosa</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="observacao" class="form-label">Observações</label>
                                        <textarea class="form-control" id="observacao" name="observacao" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="mb-3">
                                        <label for="documento" class="form-label">Anexos</label>
                                        <input class="form-control" type="file" id="documento" name="documento">
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-end mt-4">
                                    <a class="btn btn-danger mr-2" href="{{ route('Banco de Talentos') }}"><i class="bi bi-dash-circle"></i> Cancelar</a>
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
