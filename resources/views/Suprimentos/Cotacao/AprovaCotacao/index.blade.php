@extends('index-modules')

@section('aside')
    @include('Suprimentos.aside')
@endsection

@section('breadcrumb')
    @include('Suprimentos.breadcrumb')
@endsection


@section('title', 'Opus Web - Aprova Cotação')

@section('content')

    <div class="">
        <livewire:Suprimentos.AprovaCotacao.ListaCotacao>
    </div>
    

@endsection
