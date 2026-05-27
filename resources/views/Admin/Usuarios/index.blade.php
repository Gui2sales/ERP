@extends('index-modules')

@section('breadcrumb')
    @include('Admin/breadcrumb')
@endsection

@section('aside')
    @include('Admin/aside')
@endsection

@section('title', 'Opus Web - Administração de Usuários')

@section('content')
    
    <livewire:Administracao.Usuarios>
    
@endsection
