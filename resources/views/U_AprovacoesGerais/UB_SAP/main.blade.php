@extends('index-modules')

@section('aside')
    @include('U_AprovacoesGerais.UB_SAP.aside')
@endsection

@section('title', 'Opus Web - SAP')

@section('content')

    <h3 class="fs-3 pt-5">SAP (UB) </h3>

    <div class="container-fluid justify-content-start align-items-center mt-5">
        <div class="row">
            <div class="botoes_menu_modules cor_main_2">
                <a href="{{route('Historico de Compras')}}"><h3> Aprova/Rejeita (UBD) </h3></a>
            </div> 
        </div>
        
    </div>

@endsection
