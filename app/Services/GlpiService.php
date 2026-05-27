<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GlpiService
{
    protected string $baseUrl;
    protected string $userToken;
    protected string $appToken;

    public function __construct()
    {
        $this->baseUrl = config('services.glpi.base_url');
        $this->userToken = config('services.glpi.user_token');
        $this->appToken = config('services.glpi.app_token');
    }

    public function getSessionToken()
    {
        return Cache::remember('glpi_session_token', now()->addMinutes(30), function () {
            $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'user_token ' . $this->userToken,
                'App-Token'     => $this->appToken,
                'Content-Type'  => 'application/json',
            ])->get("{$this->baseUrl}/initSession");

            if (! $response->successful()) {
                throw new \Exception('Falha ao obter sessão no GLPI');
            }

            return $response->json('session_token');
        });
    }

    public function createTicket(array $data)
    {
        $sessionToken = $this->getSessionToken();

        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Session-Token' => $sessionToken,
            'App-Token'     => $this->appToken,
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}/Ticket", [
            'input' => $data
        ]);

        if (! $response->successful()) {
            throw new \Exception('Erro ao criar ticket: ' . $response->body());
        }

        return $response->json();
    }

    public function assignSolver(int $ticketId, int $userId)
    {
        $sessionToken = $this->getSessionToken();

        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Session-Token' => $sessionToken,
            'App-Token'     => $this->appToken,
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}/Ticket/{$ticketId}/Ticket_User/", [
            'input' => [
                'tickets_id'     => $ticketId,
                'users_id'       => $userId,
                'type'           => 2,
                'users_archived' => 0,
            ]
        ]);

        if (! $response->successful()) {
            throw new \Exception('Erro ao atribuir solver: ' . $response->body());
        }

        return $response->json();
    }

    public function createTicketWithObservers(array $ticketData, array $observerUserIds = [])
    {
        $sessionToken = $this->getSessionToken();

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Session-Token' => $sessionToken,
                'App-Token'     => $this->appToken,
                'Content-Type'  => 'application/json',
            ])
            ->post("{$this->baseUrl}/Ticket", [
                'input' => $ticketData
            ]);

        if (!$response->successful()) {
            throw new \Exception('Erro ao criar ticket: ' . $response->body());
        }

        $ticket = $response->json();
        $ticketId = $ticket['id'] ?? null;

        if (!$ticketId) {
            throw new \Exception('Ticket criado sem ID retornado');
        }

        // 2. Adicionar cada observador
        foreach ($observerUserIds as $userId) {
            Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Session-Token' => $sessionToken,
                    'App-Token'     => $this->appToken,
                    'Content-Type'  => 'application/json',
                ])
                ->post("{$this->baseUrl}/Ticket/{$ticketId}/Ticket_User/", [
                    'input' => [
                        'tickets_id' => $ticketId,
                        'users_id'   => $userId,
                        'type'       => 3,
                    ]
                ]);
        }

        return $ticket;
    }

    public function getTicketById(int $ticketId)
    {
        $sessionToken = $this->getSessionToken();

        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Session-Token' => $sessionToken,
            'App-Token'     => $this->appToken,
            'Content-Type'  => 'application/json',
        ])->get("{$this->baseUrl}/ticket/{$ticketId}");

        if (!$response->successful()) {
            throw new \Exception("Erro ao buscar ticket {$ticketId}: " . $response->body());
        }

        return $response->json();
    }

    public function closeTicket(int $ticketId, string $solutionText)
    {
        $sessionToken = $this->getSessionToken();

        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Session-Token' => $sessionToken,
            'App-Token'     => $this->appToken,
            'Content-Type'  => 'application/json',
        ])
        ->post("{$this->baseUrl}/ITILSolution", [
            'input' => [
                'items_id' => $ticketId,
                'itemtype' => "Ticket",
                'content'  => $solutionText,
                'solutiontypes_id' => 1,
            ]
        ]);

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Session-Token' => $sessionToken,
                'App-Token'     => $this->appToken,
                'Content-Type'  => 'application/json',
            ])
            ->put("{$this->baseUrl}/Ticket/{$ticketId}", [
                'input' => [
                    'id'      => $ticketId,
                    'status'  => 6,
                ]
            ]);

        if (!$response->successful()) {
            throw new \Exception("Erro ao fechar ticket {$ticketId}: " . $response->body());
        }

        return $response->json();
    }
}