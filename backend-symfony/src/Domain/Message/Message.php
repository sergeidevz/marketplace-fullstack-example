<?php

declare(strict_types=1);

namespace App\Domain;

final class Message
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $content,
        public readonly bool $is_seen,
        public readonly User $receiver,
        public readonly User $sender,
        public readonly string $created_at,
    ) {
        if ('' === \trim($content)) {
            throw new \DomainException('Content must not be empty');
        }
    }
}
