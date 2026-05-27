<?php

namespace App\Services;

use App\Exceptions\ServerErrorException;
use App\Utils\OpusUtils;
use App\Utils\Utils;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class OpusSocketService
{
    const OPUS_HOST = '192.168.1.10';
    const OPUS_PROTOCOL_VERSION = 'v1.3';
    const TIMEOUT = 120;

    /**
     * @param int $service_port
     * @throws ServerErrorException
     *
     * @return array
     */
    public static function executeService(int $service_port, array $service_params): array | null
    {
        $data = null;
        $socket_active = false;

        $service_params = Utils::recursivelyReplaceArrayValues($service_params, "\n", ' ');

        try {
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            if (!$service_port || !$service_params) {
                throw new ServerErrorException('Parâmetros inválidos para se conectar com o OPUS', [
                    'service_port' => $service_port,
                    'service_params' => $service_params
                ]);
            }

            if (!$socket) {
                throw new ServerErrorException('Erro ao criar socket para se conectar com o OPUS', [
                    'service_port' => $service_port,
                    'service_params' => $service_params
                ]);
            }

            if (!socket_connect($socket, self::OPUS_HOST, $service_port)) {
                throw new ServerErrorException('Erro ao conectar com o OPUS', [
                    'service_port' => $service_port,
                    'service_params' => $service_params
                ]);
            } else {
                $socket_active = true;
            }

            if (!str_contains(socket_read($socket, 2048), 'Protocolo ' . self::OPUS_PROTOCOL_VERSION)) {
                throw new ServerErrorException('Protocolo do OPUS não suportado', [
                    'service_port' => $service_port,
                    'service_params' => $service_params
                ]);
            }

            // Socket configuration
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => self::TIMEOUT, 'usec' => 0]);

            socket_write($socket, "consume portal-servico\n");
            foreach ($service_params as $key => $value) {
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

            socket_write($socket, "run-sub\n");

            $response = "";
            $tries = 0;
            socket_set_nonblock($socket);
            do {
                sleep(1);
                $response .= socket_read($socket, 16384);
                $tries++;
            } while (!str_contains($response, 'RUN-END!') && $tries < self::TIMEOUT);
            socket_set_block($socket);

            socket_write($socket, "\n");
            socket_close($socket);
            $socket_active = false;

            if ($tries >= 10 && !str_contains($response, 'RUN-END!')) {
                throw new ServerErrorException('Erro ao executar comando no OPUS', [
                    'service_port' => $service_port,
                    'service_params' => $service_params
                ]);
            }

            // Parse response to array
            $array = array_slice(explode("\n", $response), count($service_params));

            $array = array_map(function ($item) {
                $item = str_replace('run-vars-setval:', '', $item);
                $item = str_replace('runret-vars-setval:', '', $item);
                return $item;
            }, $array);

            $data = [];
            for ($i = 0; $i < count($array); $i++) {
                if (count(explode('=', $array[$i])) < 2) {
                    continue;
                }
                // Check if is array
                $key = explode('=', $array[$i])[0];
                $value = explode('=', $array[$i])[1];
                $data = custom_merge_recursive($data, self::contextToArray($key, $value));
            }
        } finally {
            if (isset($socket) && $socket && $socket_active) {
                socket_close($socket);
            }
        }

        array_walk_recursive($data, function (&$item) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
            }
        });

        return $data;
    }

    private static function contextToArray($key, $value): array
    {
        $has_more_keys = str_contains($key, '.');
        $array_key = $has_more_keys ? explode('.', $key)[0] : $key;
        $new_recursive_key = $has_more_keys ? substr($key, strpos($key, '.') + 1) : null;

        $data = [];
        if (str_contains($array_key, '[')) {
            // Is array
            $new_key = explode('[', $array_key)[0];

            $array_index = explode('[', $array_key)[1];
            $array_index = explode(']', $array_index)[0];

            if ($new_recursive_key) {
                $data[$new_key][$array_index] = self::contextToArray($new_recursive_key, $value);
            } else {
                $data[$new_key][$array_index] = $value;
            }
        } else {
            if ($new_recursive_key) {
                $data[$array_key] = self::contextToArray($new_recursive_key, $value);
            } else {
                $data[$array_key] = $value;
            }
        }

        return $data;
    }

    public static function prepareOpusParams($converter)
    {
        // Remove comandos
        $commands = ["\n","\t","\r","\f","\v","\0","\e","\a","\b","\033","|"];

        // Remova acentos
        $converter = str_replace($commands, " ", $converter);
        $acentos = [
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å',
            'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë',
            'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï',
            'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'ò', 'ó', 'ô', 'õ', 'ö',
            'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü',
            'Ç', 'ç', 'Ñ', 'ñ'
        ];
        $semAcentos = [
            'A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a',
            'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e',
            'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i',
            'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o',
            'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u',
            'C', 'c', 'N', 'n'
        ];

        return str_replace($acentos, $semAcentos, $converter);
    }

    public static function getSolicitacaoCompraSuprimentosPendente(): array
    {
        $user = Auth::user()->user;
        $result = self::executeService(40311, [
            'SISTEMA' => 'WSOWM01',
            'ROTINA' => 'WSOW001',
            'USUAPR' => '4001'
            // 'USUAPR' => $user
        ]);

        return $result;
    }

    public static function aprovaRecusaSolicitacaoCompraSuprimento(): array
    {
        $result = self::executeService(40311, [
            'SISTEMA' => 'WSOWM01',
            'ROTINA' => 'WSOW002',
        ]);

        return $result;
    }

    public static function getSolicitacaoCompraSuprimentoItens($filial, $cotacao): array
    {
        $user = Auth::user()->user;
        $result = self::executeService(40311, [
            'SISTEMA' => 'WSOWM01',
            'ROTINA' => 'WSOW003',
            'FILSC' => $filial,
            'SCLNUM' => $cotacao,
            'USUAPR' => '4001'
            // 'USUAPR' => $user
        ]);

        return $result;
    }

    public static function getHistoricoProdutoCompraSuprimentos($filial, $codigoProduto, $limite): array
    {
        $user = Auth::user()->user;
        $result = self::executeService(40311, [
            'SISTEMA' => 'WSOWM01',
            'ROTINA' => 'WSOW004',
            'FILSC' => $filial,
            'CODPRO' => $codigoProduto,
            'LIMITE' => $limite,
            'USUAPR' => '20295'
            // 'USUAPR' => $user
        ]);
        
        return $result;
    }
}