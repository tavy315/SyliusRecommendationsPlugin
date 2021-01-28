<?php

namespace Tavy315\SyliusRecommendationsPlugin\Entity;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface CustomerRecommendationInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function getCustomer(): ?CustomerInterface;

    public function setCustomer(CustomerInterface $customer): void;

    public function getRecommendationGroup(): ?RecommendationGroupInterface;

    public function setRecommendationGroup(RecommendationGroupInterface $recommendationGroup): void;

    /**
     * @return array<string>
     */
    public function getProducts(): array;

    public function hasProduct(string $product): bool;

    public function addProduct(string $product): void;

    public function removeProduct(string $product): void;
}
