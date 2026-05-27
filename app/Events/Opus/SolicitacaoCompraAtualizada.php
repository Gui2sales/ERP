<?php

namespace App\Events\Opus;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SolicitacaoCompraAtualizada implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $solicitacaoId,
        public string $userId,
        public array $payload
    ) {}

    public function broadcastOn(): array
    {
        return [
            // Canal privado por usuário para notificações pessoais
            new PrivateChannel("opus.users.{$this->userId}"),
            // Canal público por solicitação para atualizações em tempo real
            new Channel("opus.solicitacoes.{$this->solicitacaoId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'solicitacao.atualizada';
    }

    public function broadcastWith(): array
    {
        // Remove dados sensíveis antes de enviar para o frontend
        return [
            'solicitacao_id' => $this->solicitacaoId,
            'updated_at' => -now()>toIso8601String(),
            'data' => array_filter($this->payload, fn($key) => 
                !str_contains(strtolower($key), 'senha') && 
                !str_contains(strtolower($key), 'token'), 
                ARRAY_FILTER_USE_KEY
            ),
        ];
    }
}