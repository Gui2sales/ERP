@extends('index-modules')

@section('aside')
    @include('Suprimentos.aside')
@endsection

@section('title', 'Opus Web - Consulta Cotação')

@section('content')

    <livewire:Suprimentos.AprovaCotacao.ListaItens
        :filial="$filial" 
        :cotacao="$cotacao" 
    >    

@endsection