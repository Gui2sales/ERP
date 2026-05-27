<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Logger
{
    /**
     * Grava log apenas se não houver registro idêntico nos últimos $seconds
     */
    public static function logWithCooldown(
        string $event,
        string $status,
        array $properties = [],
        int $seconds = 60,
        ?string $logName = null,
        string $description
    ): bool {
        $userId = Auth::user()->user ?? 'guest';
        $cacheKey = "usu:{$userId}.{$event}";

        if (Cache::has($cacheKey)) {
            return false;
        }

        if($userId == 'guest'){
            $userId = 0;
        }

        Activity::create([
            'log_name' => $logName,
            'event' => $event,
            'status' => $status,
            'properties' => $properties,
            'causer_id' => $userId,
            'description' => $description,
            'causer_type' => 'OPUSWEB',
            'subject_type' => request()->ip(),
        ]);

        Cache::put($cacheKey, ($logName . ".usuario{" . $userId . "}") , $seconds);

        return true;
    }
}