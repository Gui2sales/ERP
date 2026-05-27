@extends('index-modules')

@section('aside')
    @include('TI.aside')
@endsection

@section('breadcrumb')
    @include('TI.breadcrumb')
@endsection

@section('title', 'Opus Web - TI')

@section('content')
    <h3 class="fs-3">Menu Ti</h3>

    <div class="row d-flex justify-content-start align-items-center mt-5">
        <div class="botoes_menu_modules cor_main_2">
            <a href="{{route('chamados')}}"><h3> Chamados</h3></a>
        </div> 
        
        <div class="botoes_menu_modules cor_main_2">
            <a href="{{route('missoes')}}"><h3> Missões</h3></a>
        </div>

        <div class="botoes_menu_modules cor_main_2">
            <a href="{{route('gestao')}}"><h3> Gestão</h3></a>
        </div>
    </div>
@endsection