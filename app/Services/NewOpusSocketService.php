<?php

namespace App\Services;

use App\Events\Opus\SolicitacaoCompraAtualizada;
use App\Exceptions\ServerErrorException;
use App\Utils\Utils;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NewOpusSocketService
{
    public function __construct(
        protected string $host,
        protected int $timeout = 120,
        protected string $protocolVersion = 'v1.3',
    ) {}

    /**
     * Factory method para criar instância a partir do config
     */
    public static function fromConfig(): self
    {
        return new self(
            host: config('opus.host'),
            timeout: config('opus.timeout', 120),
            protocolVersion: config('opus.protocol_version', 'v1.3'),
            // defaultUser: (string) config('opus.default_user', '')
        );
    }

    /**
     * Executa um serviço no OPUS via socket
     *
     * @throws ServerErrorException
     */
    public function executeService(int $service_port, array $service_params, string $userId): array
    {
        $socket = null;
        $socketActive = false;

        $service_params_log = Arr::except($service_params, ['SENHA', 'senha', 'PASSWORD', 'PASS','SENHAPR']);

        // Logger::logWithCooldown(
        //     event: 'executeService',
        //     properties: [
        //         'porta'    => $service_port,
        //         'variaveis' => $service_params_log
        //     ],
        //     seconds: 0,
        //     logName: 'NewOpusSocketService',
        //     status: 'start',
        //     description: 'Iniciando debug opus'
        // );

        // Sanitiza parâmetros
        $service_params = Utils::recursivelyReplaceArrayValues($service_params, ["\n", "\r", "\t"], ' ');

        try {
            Log::debug('[OPUS] Iniciando conexão', [
                'host' => $this->host,
                'port' => $service_port,
                'user_id' => $userId,
                'params' => Arr::except($service_params, ['senha', 'token', 'password','SENHA', 'senha', 'PASSWORD', 'PASS','SENHAPR'])
            ]);

            // Validações iniciais
            if (!$service_port || empty($service_params)) {
                throw new ServerErrorException('Parâmetros inválidos para conexão com o OPUS', [
                    'service_port' => $service_port,
                    'params_keys' => array_keys($service_params)
                ]);
            }

            // Cria socket
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if (!$socket) {
                throw new ServerErrorException('Falha ao criar socket: ' . socket_strerror(socket_last_error()));
            }

            // Configura timeout de conexão
            socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => 10, 'usec' => 0]);
            
            if (!socket_connect($socket, $this->host, $service_port)) {
                throw new ServerErrorException('Falha ao conectar no OPUS: ' . socket_strerror(socket_last_error($socket)), [
                    'host' => $this->host,
                    'port' => $service_port
                ]);
            }
            $socketActive = true;

            // Valida protocolo
            $greeting = socket_read($socket, 2048);
            if (!$greeting || !str_contains($greeting, 'Protocolo ' . $this->protocolVersion)) {
                throw new ServerErrorException('Protocolo incompatível com o OPUS', [
                    'expected' => $this->protocolVersion,
                    'received' => substr($greeting, 0, 100)
                ]);
            }

            // Configura timeout de leitura
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 5, 'usec' => 0]);

            // Envia comando de consumo do serviço
            socket_write($socket, "consume portal-servico\n");

            // Envia parâmetros formatados
            foreach ($service_params as $key => $value) {
                $this->writeSocketParams($socket, $key, $value);
            }

            // Executa o serviço
            socket_write($socket, "run-sub\n");

            // Lê resposta com timeout controlado
            $response = $this->readSocketResponse($socket);
            
            // Finaliza conexão
            socket_write($socket, "\n");
            
        } catch (\Throwable $e) {
            Log::error('[OPUS] Erro na execução do serviço', [
                'error' => $e->getMessage(),
                'port' => $service_port,
                'user_id' => $userId,
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ]);
            throw $e instanceof ServerErrorException ? $e : new ServerErrorException(
                'Erro interno ao comunicar com o OPUS: ' . $e->getMessage(),
                [],
                $e
            );
        } finally {
            if ($socket && $socketActive) {
                @socket_shutdown($socket);
                @socket_close($socket);
            }
        }
        // Parse e normalização da resposta
        $data = $this->parseResponse($response);
        
        // Converte encoding para UTF-8
        array_walk_recursive($data, fn (&$item) => 
            $item = is_string($item) ? mb_convert_encoding($item, 'UTF-8', 'UTF-8') : $item
        );

        Log::debug('[OPUS] Resposta processada com sucesso', [
            'port' => $service_port,
            'data_keys' => array_keys($data),
            'user_id' => $userId
        ]);

        Logger::logWithCooldown(
            event: 'executeService',
            properties: [
                'porta'    => $service_port,
                'resposta' => Arr::except($data, ['senha', 'token', 'password','SENHA','HASH','WTSTAM','WCODAC','WCODACRET','PASSWORD', 'PASS','SENHAPR']),
            ],
            seconds: 0,
            logName: 'NewOpusSocketService',
            status: 'finish',
            description: 'Finalizando debug opus'
        );

        return $data;
    }

    /**
     * Escreve parâmetros no socket com formatação correta
     */
    private function writeSocketParams($socket, string $key, mixed $value): void
    {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                $subKey++;
                if (is_array($subValue)) {
                    foreach ($subValue as $subSubKey => $subSubValue) {
                        socket_write($socket, 'run-vars-setval:' . $key . '[' . $subKey . '].' . $subSubKey . '=' . $subSubValue . "\n");
                    }
                } else {
                    socket_write($socket, 'run-vars-setval:' . $key . '[' . $subKey . ']=' . $subValue . "\n");
                }
            }
        } else {
            socket_write($socket, 'run-vars-setval:' . $key . '=' . $value . "\n");
        }
    }

    /**
     * Lê resposta do socket com controle de timeout real
     */
    private function readSocketResponse($socket): string
    {
        $response = '';
        $startTime = time();
        $bufferSize = 16384;
        $maxSilentSeconds = 30; // Timeout se não receber nada por 30s
        $lastDataTime = time();

        while (true) {
            $chunk = socket_read($socket, $bufferSize);
            
            if ($chunk === false) {
                $err = socket_last_error($socket);
                if ($err === SOCKET_ETIMEDOUT || $err === SOCKET_EWOULDBLOCK) {
                    // Verifica timeout de inatividade
                    if ((time() - $lastDataTime) >= $maxSilentSeconds) {
                        throw new ServerErrorException('Timeout de inatividade ao ler resposta do OPUS');
                    }
                    usleep(100000); // 100ms
                    continue;
                }
                throw new ServerErrorException('Erro na leitura do socket: ' . socket_strerror($err));
            }
            
            if ($chunk === '') {
                // Conexão fechada pelo servidor
                break;
            }
            
            $response .= $chunk;
            $lastDataTime = time();
            
            // Verifica marcador de fim
            if (str_contains($response, 'RUN-END!')) {
                break;
            }
            
            // Timeout absoluto
            if ((time() - $startTime) >= $this->timeout) {
                throw new ServerErrorException('Timeout máximo atingido ao aguardar resposta do OPUS', [
                    'elapsed_seconds' => time() - $startTime,
                    'response_preview' => substr($response, 0, 500)
                ]);
            }
        }

        if (!str_contains($response, 'RUN-END!')) {
            Log::warning('[OPUS] Resposta sem marcador de fim', [
                'response_length' => strlen($response),
                'preview' => substr($response, 0, 300)
            ]);
        }

        return $response;
    }

    /**
     * Parse robusto da resposta do OPUS para array estruturado
     */
    private function parseResponse(string $response): array
    {
        $lines = array_filter(
            explode("\n", trim($response)), 
            fn($line) => !empty(trim($line))
        );
        
        // Filtra apenas linhas de retorno válidas
        $dataLines = array_filter($lines, fn($line) => 
            str_starts_with($line, 'runret-vars-setval:') || 
            str_starts_with($line, 'run-vars-setval:')
        );
        
        $result = [];
        
        foreach ($dataLines as $line) {
            // Remove prefixos
            $cleanLine = preg_replace('/^run(?:ret)?-vars-setval:/', '', $line);
            
            // Garante que há um '=' para separar chave/valor
            if (!str_contains($cleanLine, '=')) {
                Log::debug('[OPUS] Linha ignorada (sem =)', ['line' => $line]);
                continue;
            }
            
            // Divide chave e valor (limita a 2 partes para preservar = no valor)
            [$key, $value] = explode('=', $cleanLine, 2);
            $key = trim($key);
            $value = trim($value);
                
            if ($key === '') {
                Log::warning('[OPUS] Chave vazia encontrada', ['line' => $line]);
                continue;
            }
            
            // Parse e merge
            $partials[] = $this->parseKeyPath($key, $value);
        }

        foreach ($partials as $partial) {
            $result = custom_merge_recursive($result, $partial);
        }

        return $result;
    }

    /**
     * Converte chave para array aninhado
     */
    private function parseKeyPath(string $key, mixed $value): array
    {
        // Caso simples: chave sem aninhamento
        if (!str_contains($key, '[') && !str_contains($key, '.')) {
            return [$key => $value];
        }
        
        // Normaliza: ITEM[1].CODIGO → ITEM.1.CODIGO
        $normalized = preg_replace('/\[([^\]]+)\]/', '.$1', $key);
        $parts = explode('.', $normalized);
        
        $result = [];
        $current = &$result;
        
        foreach ($parts as $i => $part) {
            $isLast = ($i === count($parts) - 1);
            
            if ($isLast) {
                $current[$part] = $value;
            } else {
                $current[$part] = [];
                $current = &$current[$part];
            }
        }
        
        return $result;
    }

    /**
     * Obtém solicitações de compra pendentes (com cache)
     */
    public function getSolicitacaoCompraSuprimentosPendente(): array
    {
        $userId = Auth::user()?->user;
        
        $cacheKey = "opus.suprimentos.pendentes.$userId";
        
        return Cache::remember($cacheKey, now()->addSeconds(config('opus.cache_ttl')), function () use ($userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM01',
                    'ROTINA' => 'WSOW001',
                    'USUAPR' => $userId
                ],
                userId: $userId
            );
        });
    }

    /**
     * Aprova ou recusa solicitação de compra (sem cache + broadcast)
     */
    public function aprovaRecusaSolicitacaoCompraSuprimento(array $parametros): array
    {
        $userId = Auth::user()?->user;
        
        return $this->executeService(
            service_port: config('opus.ports.suprimentos', 40311),
            service_params: [
                'SISTEMA' => 'WSOWM01',
                'ROTINA' => 'WSOW002',
                'USUAPR' => $userId,
                'ITENS' => $parametros['itensSelecionados'],
                'SENHAPR' => $parametros['senhaAprovador'],
                'FILSC' => $parametros['filial'],
                'SCLNUM' => $parametros['cotacao'],
                'SERAPR' => $parametros['usuAprovador']
            ],
            userId: $userId
        );
    }

    /**
     * Obtém itens de uma solicitação específica
     */
    public function getSolicitacaoCompraSuprimentoItens(string $filial, string $cotacao): array
    {
        $userId = Auth::user()?->user;
        
        $cacheKey = "opus.suprimentos.itens.$filial.$cotacao.$userId";       
        
        return Cache::remember($cacheKey, now()->addSeconds(config('opus.cache_ttl')), function () use ($filial, $cotacao, $userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM01',
                    'ROTINA' => 'WSOW003',
                    'FILSC' => $filial,
                    'SCLNUM' => $cotacao,
                    'USUAPR' => $userId
                ],
                userId: $userId
            );
        });
    }

    /**
     * Histórico de produto com limite
     */
    public function getHistoricoProdutoCompraSuprimentos(string $filial, string $codigoProduto, int $limite): array
    {
        $userId = Auth::user()?->user;

        $cacheKey = "opus.historico.$filial.$codigoProduto.$limite";
        
        return Cache::remember($cacheKey, now()->addSeconds(config('opus.cache_ttl')), function () use ($filial, $codigoProduto, $limite, $userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM01',
                    'ROTINA' => 'WSOW004',
                    'FILSC' => $filial,
                    'CODPRO' => $codigoProduto,
                    'LIMITE' => $limite,
                    'USUAPR' => $userId
                ],
                userId: $userId
            );
        });
    }

    public function getUsuarios(string $usuario)
    {
        return $this->executeService(
            service_port: config('opus.ports.suprimentos', 40311),
            service_params: [
                'SISTEMA' => 'WSOWM99',
                'ROTINA' => 'WSOW006',
                'WUSUAR' => $usuario,
            ],
            userId: $usuario
        );
    }

    public function validaSenha(string $usuario, string $senha, string $qualSenha)
    {
        return $this->executeService(
            service_port: config('opus.ports.suprimentos', 40311),
            service_params: [
                'SISTEMA' => 'WSOWM99',
                'ROTINA' => 'WSOW005',
                'USU' => $usuario,
                'SENHA' => $senha,
                'QUALSEN' => $qualSenha
            ],
            userId: $usuario
        );
    }

    public function getSMR(string $sistema, string $modulo, string $rotina)
    {
        $userId = Auth::user()?->user;

        $cacheKey = "opus.smr";
        
        return Cache::remember($cacheKey, now()->addMinutes(config('opus.cache_ttl')), function () use ($sistema, $modulo, $rotina, $userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM99',
                    'ROTINA' => 'WSOW007',
                    'ACAO' => "TUDO",
                    'WSIS' => $sistema,
                    'WMOD' => $modulo,
                    'WROT' => $rotina,
                ],
                userId: $userId
            );
        });
    }

    public function getFornecedor(string $codfor)
    {
        $userId = Auth::user()?->user;

        $cacheKey = "fornecedor.$codfor";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($codfor, $userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM99',
                    'ROTINA' => 'WSOW008',
                    'WEMP' => '01',
                    'CODFOR' => $codfor,
                ],
                userId: $userId
            );
        });
    }

    public function getFornecedorServicos(string $codfor)
    {
        $userId = Auth::user()?->user;

        $cacheKey = "fornecedorServicos.$codfor";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($codfor, $userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM99',
                    'ROTINA' => 'WSOW010',
                    'WEMP' => '01',
                    'CODSERV' => $codfor,
                ],
                userId: $userId
            );
        });
    }

    public function getSapPedentes()
    {
        $userId = Auth::user()?->user;
        if($userId == '9972'){
            $userId = '9904';
            // 5010
            // 9904
            // 5030
            // 20040
            // 20142
        }

        $cacheKey = "opus.SAPS.$userId";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM02',
                    'ROTINA' => 'WSOW011',
                    'WEMP' => '01',
                    'USUSAP' => $userId,
                    // 'FILTRO' => 'S'
                ],
                userId: $userId
            );
        });
    }

    public function getSap(string $numero, string $rota, string $sequencia)
    {
        $userId = Auth::user()?->user;
        if($userId == '9972'){
            $userId = '9904';
        }

        $cacheKey = "opus.SAP.$userId.$numero";      
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () 
            use ($userId, $numero, $rota, $sequencia) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA' => 'WSOWM02',
                    'ROTINA' => 'WSOW013',
                    'WEMP' => '01',
                    'USUSAP' => $userId,
                    'NUMSAP' => $numero,
                    'ROTSAP' => $rota,
                    'SERSAP' => $sequencia,
                ],
                userId: $userId
            );
        });
    }

    public function aprovaSap(string $numero, string $rota, string $sequencia, string $senha, string $acao, string $motivo, string $observacao)
    {
        $userId = Auth::user()?->user;
        
        return $this->executeService(
            service_port: config('opus.ports.suprimentos', 40311),
            service_params: [
                'SISTEMA'   => 'WSOWM02',
                'ROTINA'    => 'WSOW014',
                'WEMP'      => '01',
                'USUSAP'    => $userId,
                'NUMSAP'    => $numero,
                'ROTSAP'    => $rota,
                'SERSAP'    => $sequencia,
                'SENHA'     => $senha,
                'ACAO'     => $acao,
                'MRESAP'    => $motivo,
                'OBS'       => $observacao,
            ],
            userId: $userId
        );
    }

    public function getMotivosReprovaSAP()
    {
        $userId = Auth::user()?->user;

        $cacheKey = "opus.SAP.motivos";      
        
        return Cache::remember($cacheKey, now()->addMinutes(100), function () use ($userId) {
            return $this->executeService(
                service_port: config('opus.ports.suprimentos', 40311),
                service_params: [
                    'SISTEMA'   => 'WSOWM02',
                    'ROTINA'    => 'WSOW012',
                    'WEMP'      => '01',
                ],
                userId: $userId
            );
        });
    }
}