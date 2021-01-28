<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sylius\Component\Core\Model\Customer;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findByNamePart(string $phrase): array
    {
        return $this->createQueryBuilder('o')
                    ->where('email LIKE :email')
                    ->orWhere('first_name LIKE :first_name')
                    ->orWhere('last_name LIKE :last_name')
                    ->setParameter('email', '%' . $phrase . '%')
                    ->setParameter('first_name', '%' . $phrase . '%')
                    ->setParameter('last_name', '%' . $phrase . '%')
                    ->getQuery()
                    ->getResult();
    }
}
