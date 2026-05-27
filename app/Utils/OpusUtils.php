<?php

namespace App\Utils;

use Carbon\Carbon;

class OpusUtils
{
    public static function opusDateToStringDate(int|string|null $opusDate): string {
        if (!$opusDate || $opusDate < 0) {
            return "";
        }

        if (is_string($opusDate)) {
            $opusDate = intval($opusDate);
        }

        // Opus int start date (10000 = 1968-05-19)
        $startDate = "1970-01-01";
        $daysCount = $opusDate - 47117;
        return Carbon::createFromFormat('Y-m-d', $startDate)->addDays($daysCount)->format('Y-m-d');
    }

    public static function opusHourToStringHour(int|string|null $opusHour): string {
        if (!$opusHour || $opusHour < 0) {
            return "";
        }

        if (is_string($opusHour)) {
            $opusHour = intval($opusHour);
        }

        $hour = intdiv($opusHour, 3600);
        $minute = ($opusHour / 60) % 60;
        $seconds = $opusHour - $hour * 3600 - $minute * 60;

        $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
        $minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
        $seconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);

        return "$hour:$minute:$seconds";
    }

    public static function opusSimnaoToBool(string $value): bool {
        return $value === 'S';
    }

}
