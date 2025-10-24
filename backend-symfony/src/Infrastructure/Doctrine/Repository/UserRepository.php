<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\User;
use App\Domain\RepositoryInterface\IUserRepository;
use App\Domain\Shared\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class UserRepository implements IUserRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function remove(User $domain): void
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb->delete(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $domain->getId())
            ->getQuery();

        $q->execute();
    }

    public function update(User $domain): int
    {
        $this->em->persist($domain);
        $this->em->flush();

        return $domain->getId();
    }

    public function create(User $domain): int
    {
        $this->em->persist($domain);
        $this->em->flush();

        return $domain->getId();
    }

    public function getById(int $id): User
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException) {
            throw new NotFoundException("User $id not found");
        }

        return $user;
    }

    public function getByEmail(string $email): User
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery();

        $user = $q->getSingleResult();

        NotFoundException::throwIfNull($user);

        return $user;
    }

    public function getByDisplayName(string $displayName): User
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.display_name = :displayName')
            ->setParameter('displayName', $displayName)
            ->getQuery();

        $user = $q->getSingleResult();

        NotFoundException::throwIfNull($user);

        return $user;
    }

    public function getAll(): array
    {
        $qb = $this->em->createQueryBuilder();
        $categories = $qb->select('u')
            ->from(User::class, 'u')
            ->getQuery()
            ->getResult();

        return $categories;
    }
}
