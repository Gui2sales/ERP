<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCode;

class ServerErrorException extends GenericException
{
    public function __construct($message = 'Usuário não está autenticado', array $args = [])
    {
        parent::__construct($message, $args, HttpStatusCode::InternalServerError);
    }
}