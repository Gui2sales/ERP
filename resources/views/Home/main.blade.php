@extends('index')

@section('title', 'Opus Web - Home')

@section('content')

    <div>
        <img class="only_pc" src="{{ asset('images/Opuswebv6.png') }}" alt="background">
        <livewire:Components.Menus>
    </div>
    @livewireScripts
@endsection
 