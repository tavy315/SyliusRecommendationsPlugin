<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\ORM\EntityManager;

trait CustomerRepositoryTrait
{
    /**
     * @return EntityManager
     */
    abstract protected function getEntityManager();

    /**
     * @return string
     */
    abstract protected function getEntityName();

    public function findByPart(string $phrase): array
    {
        return $this->createQueryBuilder('o')
                    ->where('o.email LIKE :email')
                    ->orWhere('o.firstName LIKE :first_name')
                    ->orWhere('o.lastName LIKE :last_name')
                    ->setParameter('email', '%' . $phrase . '%')
                    ->setParameter('first_name', '%' . $phrase . '%')
                    ->setParameter('last_name', '%' . $phrase . '%')
                    ->getQuery()
                    ->getResult();
    }
}
