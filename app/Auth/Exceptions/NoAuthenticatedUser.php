<?php

declare(strict_types=1);

namespace App\Auth\Exceptions;

use RuntimeException;
use Throwable;

class NoAuthenticatedUser extends RuntimeException
{
    /**
     * @param Throwable|null $previous The previous exception
     * @param int            $code     The internal exception code
     */
    public function __construct(?Throwable $previous = null, int $code = 0)
    {
        parent::__construct('No user is currently authenticated.', $code, $previous);
    }
}
