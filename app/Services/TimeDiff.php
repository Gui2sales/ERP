<?php

namespace App\Services;

use DateTime;

class TimeDiff
{
    protected string $baseUrl;
    protected string $userToken;

    public function formatarDuracaoHumanizada($inicio, $fim) 
    {
        $dtInicio = new DateTime($inicio);
        $dtFim    = new DateTime($fim);
        $diff     = $dtFim->diff($dtInicio);

        $totalSegundos = ($diff->days * 86400) + ($diff->h * 3600) + ($diff->i * 60) + $diff->s;

        if ($totalSegundos < 3600) {
            $minutos = intval(ceil($totalSegundos / 60));
            return $minutos === 1 ? '1 minuto' : "$minutos minutos";
        } elseif ($totalSegundos < 86400) {
            $horas   = $diff->h;
            $minutos = $diff->i;

            $partes = [];
            if ($horas > 0) {
                $partes[] = $horas === 1 ? '1 hora' : "$horas horas";
            }
            if ($minutos > 0) {
                $partes[] = $minutos === 1 ? '1 minuto' : "$minutos minutos";
            }

            return implode(' e ', $partes);
        } else {
            $dias = $diff->days;

            if ($diff->h > 0) {
                $horas = $diff->h;
                return "$dias dias e " . ($horas === 1 ? '1 hora' : "$horas horas");
            }

            return $dias === 1 ? '1 dia' : "$dias dias";
        }
    }
}