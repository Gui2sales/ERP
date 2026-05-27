<div class="card">
    @if(!$missaoAt)
        <div wire:init="loadMissaoAt" class="btn btn-warning botao-link">
            <div class="spinner-border" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
            <p>Carregando missão, aguarde...</p>
        </div>
    @else
        <a href="#secao-destino"
            @empty ($missaoAtual)
                class="btn btn-warning botao-link">
                Nenhuma missão em andamento, atribua uma missão para começar.
            @else
                class="btn btn-primary botao-link">
                <div 
                    x-text="Chamado em andamento á"
                    x-data="elapsedTimer('{{ $missaoAtual->start }}')" 
                    x-init="startTimer()"
                >
                    <span class="label">Chamado <b>{{ $missaoAtual->chamado }}</b> ativo à </span>
                    <br>
                    <b><span x-text="formatted" class="timer-value"></span></b>
                </div>
            @endempty
        </a>
    @endif
</div>

@push('scripts')
    <script>
        function elapsedTimer(startTimeString) {
            return {
                startTime: null,
                formatted: '',
                interval: null,
                
                startTimer() {
                    // Garante compatibilidade com datas do banco (substitui espaço por 'T' para ISO 8601)
                    this.startTime = new Date(startTimeString.replace(' ', 'T'));
                    this.tick(); // Executa imediatamente
                    this.interval = setInterval(() => this.tick(), 1000);
                },
                
                tick() {
                    if (!this.startTime) return;
                    
                    const now = new Date();
                    // Calcula diferença em segundos
                    const diffSeconds = Math.floor((now - this.startTime) / 1000);
                    
                    // Atualiza a propriedade reativa 'formatted'
                    this.formatted = this.formatDetailedDuration(Math.max(0, diffSeconds));
                },
                
                formatDetailedDuration(totalSeconds) {
                    if (totalSeconds <= 0) return '0 segundos';

                    const days = Math.floor(totalSeconds / 86400);
                    const hours = Math.floor((totalSeconds % 86400) / 3600);
                    const minutes = Math.floor((totalSeconds % 3600) / 60);
                    const seconds = totalSeconds % 60;

                    const parts = [];
                    if (days > 0) parts.push(`${days} dia${days !== 1 ? 's' : ''}`);
                    if (hours > 0) parts.push(`${hours} hora${hours !== 1 ? 's' : ''}`);
                    if (minutes > 0) parts.push(`${minutes} minuto${minutes !== 1 ? 's' : ''}`);
                    // Mostra segundos se for o único item ou se houver outros
                    if (seconds > 0 || parts.length === 0) parts.push(`${seconds} segundo${seconds !== 1 ? 's' : ''}`);

                    // Lógica de formatação PT-BR (vírgulas e "e")
                    if (parts.length === 1) return parts[0];
                    if (parts.length === 2) return parts.join(' e ');
                    
                    const last = parts.pop();
                    return parts.join(', ') + ' e ' + last;
                }
            }
        }
    </script>
@endpush