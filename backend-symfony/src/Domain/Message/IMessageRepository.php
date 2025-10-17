<?php

declare(strict_types=1);

namespace App\Domain;

interface IMessageRepository
{
    public function save(Message $domain);

    /**
     * @return Message[]
     */
    public function findAll(): array;

    public function findById(string $id): ?Message;
}
