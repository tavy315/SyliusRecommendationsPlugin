<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;

interface CustomerRecommendationRepositoryInterface extends RepositoryInterface
{
    public function findByCustomer(CustomerInterface $customer, RecommendationGroupInterface $group): ?CustomerRecommendationInterface;

    public function findOneByCustomerAndRecommendationGroup(string $customerId, string $recommendationGroupCode): ?CustomerRecommendationInterface;

    /**
     * @return array<CustomerRecommendationInterface>
     */
    public function findGroupsByCustomer(CustomerInterface $customer): array;

    public function findGroupsByCustomerId(string $customerId): QueryBuilder;
}
