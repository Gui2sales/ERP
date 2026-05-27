<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <link rel="icon" href="/images/favicon.ico" sizes="192x192">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
    @vite(['resources/js/app.js'
        , 'resources/css/app.scss'
        , 'resources/css/main.scss'
        , 'resources/css/botoes.scss'
        , 'resources/css/tabela.scss'
        , 'resources/css/graficos.scss'
    ])
</head>
<body>
    <main>
        @include('header')
        <nav class="cor_main_2">
            <div>
                @yield('aside')
            </div>
            <livewire:Components.Perfil>
        </nav>
        <section id="section_modules">
            @yield('breadcrumb')
            @yield('content')
        </section>  
    </main>
    
    
    <footer></footer>
    
    @livewireScripts

    @stack('modals')
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>