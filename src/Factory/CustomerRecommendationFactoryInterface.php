<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Factory;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;

interface CustomerRecommendationFactoryInterface extends FactoryInterface
{
    public function createForCustomer(CustomerInterface $customer): CustomerRecommendationInterface;

    public function createNew(): CustomerRecommendationInterface;
}
