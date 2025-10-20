<?php

declare(strict_types=1);

namespace App\Domain\Message;

interface IMessageRepository
{
    public function save(Message $domain): string;

    /**
     * @return Message[]
     */
    public function getAll(): array;

    public function getById(string $id): Message;

    public function remove(Message $domain): void;
}
