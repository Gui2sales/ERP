<div>
    <h3 class="mb-4">Aprovando SAP</h3>

    @if(!$exibeSAP)
        <div wire:init="loadExibeSAP">
            <div colspan="9" class="text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Carregando...</span>
                </div>
                <p>Carregando relatório, aguarde...</p>
            </div>
        </div>
    @elseif ($numero == $sap['NUMSAP'] && $rota == $sap['ROTSAP'] && $sequencia == $sap['SERSAP'] && isset($sap['FONSAP']))
        @if ($sap['FONSAP'] == "CSERVFI")
            @include('Livewire.AprovacoesGerais.AprovaSAP.SAP1')
        @elseif($sap['FONSAP'] == "TRRP")
            @include('Livewire.AprovacoesGerais.AprovaSAP.SAP3')
        @elseif($sap['FONSAP'] == "TRDV")
            @include('Livewire.AprovacoesGerais.AprovaSAP.SAP4')
        @endif
        @if ($sap['URL'])
            <div class="cartao mt-3">
                <h3 class="mb-3"> DRIVE: <span><a href="{{$sap['URL']}}" target="_blank" class="fonte_azul">{{$sap['URL']}}</a></span></h3> 
                <iframe src="https://drive.google.com/embeddedfolderview?id={{substr($sap['URL'],39,33)}}#list" frameborder="0" class="w-100"></iframe>
            </div>
        @endif
        <div class="cartao mt-3">
            <h3 class="mb-3"> Aprovadores</h3>
            <div class="container-fluid">
                <div class="row">
                    @foreach ( $sap['aprvadores'] as $aprvador)
                        <div class="row col fw-bold
                            @if ($aprvador['acao'] == "A")
                                fonte_verde
                            @else
                                fonte_cinza
                            @endif
                        ">
                            <span class="text-center"> {{$aprvador['aprovador']}}</span>
                            <span class="text-center"> {{$aprvador['dataAprovacao'] . " - " . $aprvador['horaAprovacao']}}</span>
                            @if ($aprvador['acao'] == "A")
                                <span class="text-center"> {{ "Rota: " . $aprvador['rota'] . " Ação: Aprovado!"}}</span>
                            @else
                                <span class="text-center"> {{ "Rota: " . $aprvador['rota'] . " Ação Pendente!"}}</span>
                            @endif            
                        </div>
                        @empty($aprvador['ultimo'])
                            <div class="d-inline-block w-1 fs-4 fw-bold text-center align-content-center
                                @if ($aprvador['acao'] == "A")
                                    fonte_verde
                                @else
                                    fonte_cinza
                                @endif
                                ">
                                    <i class="bi bi-arrow-right"></i>
                            </div>
                        @endempty
                    @endforeach
                </div>
            </div>
        </div>
        <form wire:submit='aprovaRecusa'>
            <div class="cartao rounded-md my-3 container-fluid">
                <div class="row">
                    <p>
                        <span class="fs-4$ fw-bold">Finalizar</span>
                        <span
                        @if($msgErro == "SAP Aprovada com Sucesso!")
                            class="text-success mt-3 ml-1"
                        @else
                            class="text-danger mt-3 ml-1"
                        @endif
                    >{{$msgErro}} {{$retornoOpus}} </span> 
                    </p>
                    <div class="col-12 row">
                        <textarea class="form-control ml-3 mt-3 mb-2" rows="1" wire:model.defer="observacao" placeholder="Observação"></textarea>
                        <div class="col-12 col-md-6">
                            <select class="form-control mt-1" name="motivo" id="motivo" wire:model.live='motivo' 
                                @if ($acao !== "R")
                                    disabled
                                @endif
                            >
                                <option value="padrao">Selecionar</option>
                                @foreach ($motivos["motivosReprovacao"] as $mot)
                                    <option value="{{$mot['codigoMotivo']}}">{{$mot['motivo']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control mt-1" name="acao" id="acao" wire:model.live='acao'>
                                <option value="padrao">Selecionar</option>
                                <option value="A">Aprovar</option>
                                <option value="R">Recusar</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="password" wire:model="senhaAprovacao" class="form-control mt-1" placeholder="Senha aprovação">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary mt-1 w-100">Enviar</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
    @else
        @isset($this->erro)
            <p class="text-danger">{{$this->erro}}</p>
        @else
            <div>
                <p class="text-danger">Erro: contacte a equipe de TI.</p>
                <button class="btn btn-secondary mt-5" wire:click='error'> Voltar </button>
            </div>
        @endisset
    @endif
</div>