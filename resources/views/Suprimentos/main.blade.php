@extends('index-modules')

@section('aside')
    @include('Suprimentos.aside')
@endsection

@section('title', 'Opus Web - Suprimentos')

@section('content')

    <h3 class="fs-3 pt-5">Cotação</h3>

    <div class="row d-flex justify-content-start align-items-center mt-5">
        <div class="botoes_menu_modules cor_main_2">
            <a href="{{route('Aprova Cotação')}}"><h3> Aprova Cotação (VCF) </h3></a>
        </div>
        {{-- <livewire:Components.rotinas :modulo='$modulo = "VC"' > --}}        
    </div>

@endsection
