<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Context;

use Symfony\Component\HttpFoundation\Request;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;

interface CustomerRecommendationContextInterface
{
    public function getCustomerRecommendation(Request $request): CustomerRecommendationInterface;

    /**
     * @return array<CustomerRecommendationInterface>
     */
    public function getCustomerRecommendations(): array;
}
