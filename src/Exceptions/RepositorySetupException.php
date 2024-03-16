<?php

namespace Devinci\LaravelUtils\Exceptions;

use Exception;

class RepositorySetupException extends Exception
{
    public function __construct($message = 'Repository setup is required', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function missingFiles(): static
    {
        return new static('Stubs or base repository file is missing. Run "php artisan repository:setup" to set up.');
    }
}
