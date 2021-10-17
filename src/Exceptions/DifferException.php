<?php

declare(strict_types=1);

namespace Differ\Exceptions;

use Exception;

abstract class DifferException extends Exception
{
    public function prepareMessage(): string
    {
        $exceptionClassBasename = explode('\\', static::class);
        /** @var string $exceptionClassName */
        $exceptionClassName = preg_replace('/Exception$/', '', end($exceptionClassBasename));
        /** @var string[] $pieces */
        $pieces = preg_split('/(?=[A-Z])/', $exceptionClassName);
        $error = ucfirst(strtolower(trim(implode(' ', $pieces))));

        return vsprintf('%s: %s', [$error, $this->getMessage()]);
    }
}
