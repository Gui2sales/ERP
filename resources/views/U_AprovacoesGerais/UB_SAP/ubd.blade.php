@extends('index-modules')

@section('aside')
    @include('U_AprovacoesGerais.UB_SAP.aside')
@endsection

@section('breadcrumb')
    @include('U_AprovacoesGerais.UB_SAP.breadcrumb')
@endsection

@section('title', 'Opus Web - SAP')

@section('content')

    <div class="">
        <livewire:AprovacoesGerais.AprovaSAP.ListaSaps>
    </div>
    {{--  --}}

@endsection
