<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    use CustomerRepositoryTrait;
}
