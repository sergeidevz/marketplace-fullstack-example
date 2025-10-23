<?php

declare(strict_types=1);

namespace App\Domain\Shared;

class NotFoundException extends \RuntimeException
{
    public static function throwIfNull(mixed $value, string $message = 'Not found'): void
    {
        if (null === $value) {
            throw new self($message);
        }
    }
}
