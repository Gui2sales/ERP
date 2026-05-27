<?php

namespace App\Services;

use PDO;
use PDOException;

class DataLakeDBService
{
    protected static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (!self::$instance) {
            $config = require __DIR__ . '/../config/database.php';
            $db = $config['datalake'] ?? null;

            if (!$db || empty($db['host']) || empty($db['database'])) {
                throw new PDOException('Configuração do DataLake incompleta no .env ou database.config');
            }

            // Monta DSN e opções conforme o driver
            if ($db['driver'] === 'sqlsrv') {
                $dsn = "sqlsrv:Server={$db['host']},{$db['port']};Database={$db['database']}";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::SQLSRV_ATTR_QUERY_TIMEOUT => $db['timeout'], // em segundos
                ];
            } else {
                // dblib (FreeTDS)
                $dsn = "{$db['driver']}:host={$db['host']}:{$db['port']};dbname={$db['database']}";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT            => $db['timeout'], // apenas timeout de conexão
                ];
            }

            try {
                self::$instance = new PDO($dsn, $db['username'], $db['password'], $options);
            } catch (PDOException $e) {
                // Logue o erro em produção. Evite expor detalhes sensíveis.
                throw new PDOException('Falha ao conectar ao DataLake: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    public static function selectOne(string $query, array $bindings = []): array|false
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute($bindings);
        return $stmt->fetch();
    }

    public static function select(string $query, array $bindings = []): array
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }
}