@extends('index-modules')

@section('aside')
    @include('TI.aside')
@endsection

@section('breadcrumb')
    @include('TI.breadcrumb')
@endsection

@section('title', 'Opus Web - TI')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="row justify-content-between align-items-center">
        <div class="col-3">
            <h3 class="fs-3 mt-5">Gestão</h3>
        </div>
    </div>

    <div class="justify-content-between mt-5">
        <div class="cartao col-lg-12">
            <div class="card-body px-4 py-4">
                <div class="row">
                    <div class="col-6">
                        <canvas id="graficoProjetos"></canvas>
                    </div>
                    <div class="col-6">
                        <canvas id="graficoVs"></canvas>
                    </div>
                </div>
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
    
    <br>
    
    <div class="cartao">
        <div class="card-body table-responsive px-4 py-4 col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="card-title">Missões à Atribuir ( {{$chamados}} )</h3>
                <a class="btn btn-success" href="{{ route('gestao.create') }}"><i class="bi bi-plus"></i> Adicionar</a>
            </div>
            <hr>
            <table class="table table-hover">
                <thead>
                    <th>Chamado</th>
                    <th>Solicitante</th>
                    <th>Tit Chamado</th>
                    <th>Descrição</th>
                    <th>Dt Abertura</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($missoes as $missao)
                        <tr>
                            <td>
                                @if(ctype_digit($missao->id ))
                                    <a href="https://helpdesk.pacaembuautopecas.com.br/front/ticket.form.php?id={{$missao->id }}" 
                                            target="blank"
                                            class="links">
                                            {{ $missao->id }}
                                    </a>
                                @else
                                    {{ $missao->id }}
                                @endif
                            </td>
                            <td>{{ $missao->dn_requesters_users[0]['fullname'] }}</td>
                            <td>{{ $missao->name }}</td>
                            <td>{{ Str::limit( strip_tags(html_entity_decode($missao->content, ENT_QUOTES, 'UTF-8')), 100, ' [...]') }}</td>
                            <td>{{ \Carbon\Carbon::parse($missao->dn_date)->format('d/m/Y')}}</td>
                            <td>{{ $missao->dn_category_name }}</td>
                            <td>
                                <a href="{{ route('gestao.edit', $missao->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 w-100">
                {{ $missoes->links() }} 
            </div>
        </div>
    </div>

    <br>

    <div class="cartao">
        <livewire:TI.Gestao.MissoesTotaisEA>
    </div>

    <br>
        
    <div class="cartao" id="lista_missoes_totais">
        <livewire:TI.Gestao.MissoesEncerradasTot>
    </div>
    
@endsection

@push('scripts')
    <script>
        Chart.register(ChartDataLabels);
        const ctx1 = document.getElementById('graficoProjetos').getContext('2d');
        const ctx2 = document.getElementById('graficoVs').getContext('2d');

        const missoes = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: [
                    @if($emAberto) 
                        'Em Aberto'
                    @endif

                    @if($encerradas) 
                        , 'Encerradas'
                    @endif

                    @if($chamados)
                        , 'À Atribuir'
                    @endif
                ],
                datasets: [{
                    label: 'Missões',
                    data: [ 
                        @if($emAberto) 
                            {{ $emAberto }}
                        @endif
                        
                        @if($encerradas) 
                            , {{ $encerradas }}
                        @endif

                        @if($chamados)
                            , {{ $chamados }} 
                        @endif                        
                    ],
                    backgroundColor: [
                        'rgb(265, 0, 40)',
                        'rgb(54, 162, 0)',
                        'rgb(20, 20, 250)',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Missões em aberto'
                    },
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value, ctx) => {
                            const label = ctx.chart.data.labels[ctx.dataIndex];
                            return `${label} ${value}`;
                        }
                    }
                }
            }
        });

        const config = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($porColaborador as $colab)
                        "{{ addslashes(e($colab->name)) }}",
                    @endforeach
                ],
                datasets: [
                {
                    label: 'Atribuidos',
                    data: [
                        @foreach($porColaborador as $colab)
                            "{{ addslashes(e($colab->abertas)) }}",
                        @endforeach
                    ],
                    backgroundColor: 'rgb(265, 0, 40)',
                    borderColor: 'rgb(225, 0, 2)',
                    borderWidth: 1
                },
                {
                    label: 'Encerrados',
                    data: [
                        @foreach($porColaborador as $colab)
                            "{{ addslashes(e($colab->encerradas)) }}",
                        @endforeach
                    ],
                    backgroundColor: 'rgb(54, 162, 0)',
                    borderColor: 'rgb(8, 90, 20)',
                    borderWidth: 1
                }
            ]
            },
            options: {
                indexAxis: 'y', // ←←← Isso faz as barras serem horizontais!
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantidade'
                        }
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                    }
                }
            }
        });
    </script>
@endpush