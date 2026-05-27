<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCode;
use Exception;
use Illuminate\Support\Facades\Log;

class GenericException extends Exception
{
    public array $args;

    public function __construct(string $message, array $args = [], HttpStatusCode $exceptionType)
    {
        $this->args = $args;
        parent::__construct($message, $exceptionType->value);
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage()
        ], $this->getCode());
    }

    public function report()
    {
        Log::error(self::class . ' ' . $this->getMessage(), $this->args);
    }
}