<?php

namespace App\Utils;

class OperationResult
{
    public function __construct(
        public mixed  $data = null,
        public string $message = '',
        public array  $errors = [],
        public bool   $isError = false,
        public int    $code = 200
    )
    {
    }

    public static function success(
        mixed $data = null,
        int   $code = 200
    ): self
    {
        return new self(
            data: $data,
            code: $code
        );
    }

    public static function error(
        string $message = '',
        array  $errors = [],
        int    $code = 400
    ): self
    {
        return new self(
            message: $message,
            errors: $errors,
            isError: true,
            code: $code
        );
    }
}
