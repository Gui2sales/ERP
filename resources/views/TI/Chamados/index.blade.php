@extends('index-modules')

@section('aside')
    @include('TI.aside')
@endsection

@section('breadcrumb')
    @include('TI.breadcrumb')
@endsection

@section('title', 'Opus Web - TI')

@section('content')

    <h3 class="fs-3">Chamados</h3>
    
    <div class="row mt-4">
        <div class="cartao col-2 ml-3">
            <div class="card-body justify-items-center">
                <h5 class="card-title">Chamados em aberto</h5>
                <p class="card-text card_chamados">{{$emAbertoSistemas}}</p>
            </div>
        </div>
        <div class="cartao col-2 ml-3">
            <div class="card-body justify-items-center">
                <h5 class="card-title">Sem usuário atribuido</h5>
                <p class="card-text card_chamados">{{$novos}}</p>
            </div>
        </div>
    </div>

    <div class="justify-content-between mt-5">
        <div class="cartao col-lg-5">
            <div class="card-body px-4 py-4">
                <canvas id="graficoChamados"></canvas>
            </div>
        </div>
    </div>

    <br>

    <div class="cartao">
        <div class="px-4 py-4">
            <h3 class="mb-4">Chamados</h3>
            <hr>
            <table class="table table-hover">
                <thead>
                    <th>Chamado</th>
                    <th>Requisição</th>
                    <th>Data de abertura</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    @foreach ($ti as $chamados)
                        <tr>
                            <td>
                                <a href="https://helpdesk.pacaembuautopecas.com.br/front/ticket.form.php?id={{$chamados->id }}" 
                                    target="blank"
                                    class="links">
                                    {{ $chamados->id }}
                                </a>
                            </td>
                            <td>{{ $chamados->name }}</td>
                            <td>{{ $chamados->date }}</td>
                            <td>
                                @if ($chamados->status == 1)
                                Novo
                                @elseif($chamados->status == 2)
                                    Em Atendimento
                                @elseif($chamados->status == 3 || $chamados->status == 4)
                                    Pendente
                                @elseif($chamados->status == 5 || $chamados->status == 6)
                                    Encerrado
                                @else
                                    {{$chamados->status}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <form method="GET" action="{{ request()->url() }}">
                <label for="limite">Itens por página:</label>
                <select name="limite" id="limite" onchange="this.form.submit();">
                    @foreach($limitesPermitidos as $valor)
                        <option value="{{ $valor }}" {{ $limite == $valor ? 'selected' : '' }}>
                            {{ $valor }}
                        </option>
                    @endforeach
                </select>
            </form>
            {{ $ti->onEachSide(1)->links()}}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        Chart.register(ChartDataLabels);
        const ctx = document.getElementById('graficoChamados').getContext('2d');
        
        const dataDe = + {{ $diaDe }} + '/' + {{ $mesDe }} + '/' + {{ $anoDe }};
        const dataAte = + {{ $diaAte }} + '/' + {{ $mesAte }} + '/' + {{ $anoAte }};

        const chamados = new Chart(ctx, {
            type: 'pie', // Tipo do gráfico: 'bar', 'line', 'pie', 'doughnut', etc. [10, 15]
            data: {
                labels: [
                    'Encerrados',
                    'Abertos',
                ],
                datasets: [{
                    label: 'Chamados',
                    data: [ {{$fechadoSistemas}}, {{$abertoSistemas}} ],
                    backgroundColor: [
                        'rgb(54, 162, 0)',
                        'rgb(265, 0, 40)',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: `Chamados de Sistemas de ${dataDe}  até ${dataAte}`
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
    </script>
@endpush