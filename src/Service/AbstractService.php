<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class AbstractService
{
    protected EntityManagerInterface $entityManager;
    protected EntityRepository $repository;
    protected string $entityClass;

    public function __construct(EntityManagerInterface $entityManager, string $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $this->repository = $entityManager->getRepository($entityClass);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function find(int $id): ?object
    {
        return $this->repository->find($id);
    }

    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria): ?object
    {
        return $this->repository->findOneBy($criteria);
    }

    public function save(object $entity, bool $flush = true): void
    {
        $this->entityManager->persist($entity);
        
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function remove(object $entity, bool $flush = true): void
    {
        $this->entityManager->remove($entity);
        
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function count(array $criteria = []): int
    {
        return $this->repository->count($criteria);
    }
}
