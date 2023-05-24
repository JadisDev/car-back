<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{

    public function __construct($message = "Informação não encontrada", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}