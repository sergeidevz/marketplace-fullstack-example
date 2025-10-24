<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\RepositoryInterface\IUserRepository;

final class UserService
{
    public function __construct(
        private readonly IUserRepository $userRepository,
    ) {
    }

    public function create(User $domain): int
    {
        $id = $this->userRepository->create($domain);

        return $id;
    }

    public function update(User $domain): int
    {
        $id = $this->userRepository->update($domain);

        return $id;
    }

    public function remove(User $domain): void
    {
        $this->userRepository->remove($domain);
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        return $this->userRepository->getAll();
    }

    public function getById(int $id): User
    {
        return $this->userRepository->getById($id);
    }
}
