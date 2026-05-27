<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body class="h-100">
    @vite(['resources/css/app.scss'])
    @vite(['resources/js/app.js'])
    @vite(['resources/css/main.scss'])
    @vite(['resources/css/logo.scss'])

    <header class="d-inline-block" id="header_login">
        <div class="justify-content-center d-flex mt-1 mb-1 pt-3">
            @include('components/logo_branco')
        </div>
    </header>

    <section class="d-inline-block" id="tela_login">
        <livewire:Login.Login>
    </section>
    <footer></footer>
</body>
</html>