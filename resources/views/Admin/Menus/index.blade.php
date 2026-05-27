@extends('index-modules')

@section('breadcrumb')
    @include('Admin/breadcrumb')
@endsection

@section('aside')
    @include('Admin.aside')
@endsection

@section('title', 'Opus Web - Administração de Menus')

@section('content')

    <div>
        @if(session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif

        @can('admin.menus')
            <livewire:Administracao.Menus>
        @endcan
    </div>
@endsection