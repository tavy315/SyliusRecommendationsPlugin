<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Sylius\Component\Core\Repository\CustomerRepositoryInterface as BaseCustomerRepositoryInterface;

interface CustomerRepositoryInterface extends BaseCustomerRepositoryInterface
{
    public function findByPart(string $phrase): array;
}
