<?php
// config/opus.php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações de Conexão OPUS
    |--------------------------------------------------------------------------
    */
    'host' => env('OPUS_HOST', '192.168.1.10'),
    'protocol_version' => env('OPUS_PROTOCOL_VERSION', 'v1.3'),
    'timeout' => (int) env('OPUS_TIMEOUT', 120),
    'default_user' => env('OPUS_DEFAULT_USER', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Portas dos Serviços
    |--------------------------------------------------------------------------
    */
    'ports' => [
        'suprimentos' => (int) env('OPUS_PORT_SUPRIMENTOS', 40311),
        // Adicione outras portas conforme necessário
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */
    'cache_ttl' => (int) env('OPUS_CACHE_TTL', 300), // 5 minutos padrão
    
    /*
    |--------------------------------------------------------------------------
    | Broadcasting (Reverb)
    |--------------------------------------------------------------------------
    */
    'broadcast' => [
        'enabled' => env('OPUS_BROADCAST_ENABLED', true),
        'channel_prefix' => 'opus.',
    ],
];