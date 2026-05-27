@extends('index-modules')

@section('aside')
    @include('TI.aside')
@endsection

@section('breadcrumb')
    @include('TI.breadcrumb')
@endsection

@section('title', 'Opus Web - TI')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Cabeçalho -->
    <div class="row justify-content-between align-items-center">
        <div class="col-3">
            <h3 class="fs-3">Missões</h3>
        </div>
        <div class="col-4">
            <livewire:TI.Missoes.MissaoAtual>
        </div>
    </div>

    <br id="secao-destino">

    <!-- Missões Individuais -->
    <div class="cartao">
        <livewire:TI.Missoes.MissoesAtribuidas>
    </div>

    <!-- Missões Encerradas -->
    
    <br>        
    <div class="cartao">
        <livewire:TI.Missoes.MissoesEncerradas>
    </div>
    
@endsection