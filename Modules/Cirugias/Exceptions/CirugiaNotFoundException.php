<?php

namespace Modules\Cirugias\Exceptions;

use Exception;

class CirugiaNotFoundException extends Exception
{
    public function __construct(string $message = "Cirugía no encontrada", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}

class CirugiaValidationException extends Exception
{
    protected $errors;

    public function __construct(array $errors = [], string $message = "Error de validación", int $code = 422)
    {
        $this->errors = $errors;
        parent::__construct($message, $code);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

// Add other specific exception types as needed
