<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Factory;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;

final class CustomerRecommendationFactory implements CustomerRecommendationFactoryInterface
{
    /** @var FactoryInterface */
    private $customerRecommendationFactory;

    public function __construct(FactoryInterface $customerRecommendationFactory)
    {
        $this->customerRecommendationFactory = $customerRecommendationFactory;
    }

    public function createForCustomer(CustomerInterface $customer): CustomerRecommendationInterface
    {
        $recommendation = $this->createNew();
        $recommendation->setCustomer($customer);

        return $recommendation;
    }

    public function createForCustomerAndRecommendation(CustomerInterface $customer, RecommendationGroupInterface $recommendationGroup): CustomerRecommendationInterface
    {
        $recommendation = $this->createNew();
        $recommendation->setCustomer($customer);
        $recommendation->setRecommendationGroup($recommendationGroup);

        return $recommendation;
    }

    public function createNew(): CustomerRecommendationInterface
    {
        /** @var CustomerRecommendationInterface $recommendation */
        $recommendation = $this->customerRecommendationFactory->createNew();

        return $recommendation;
    }
}
