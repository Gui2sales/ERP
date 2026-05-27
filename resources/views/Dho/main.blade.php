@extends('index-modules')

@section('aside')
    @include('Dho.aside')
@endsection

@section('title', 'Opus Web - Desenvolvimento Humano')

@section('content')

    <h3 class="fs-3 pt-5">Menu DHO</h3>

    <div class="row d-flex justify-content-start align-items-center mt-5">
        @canany(['dho'])
            @can('dho')
                <div class="botoes_menu_modules cor_main_2">
                    <a href="{{route('Banco de Talentos')}}"><h3> Banco de Talentos </h3></a>
                </div> 
            @endcan
        @endcanany
    </div>
    
@endsection
