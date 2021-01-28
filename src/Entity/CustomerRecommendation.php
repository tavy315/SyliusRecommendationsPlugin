<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Entity;

use Sylius\Component\Customer\Model\CustomerInterface;

class CustomerRecommendation implements CustomerRecommendationInterface
{
    /** @var int */
    protected $id;

    /** @var CustomerInterface|null */
    protected $customer;

    /** @var RecommendationGroupInterface|null */
    protected $recommendationGroup;

    /** @var array<string> */
    protected $products = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    public function getRecommendationGroup(): ?RecommendationGroupInterface
    {
        return $this->recommendationGroup;
    }

    public function setRecommendationGroup(?RecommendationGroupInterface $recommendationGroup): void
    {
        $this->recommendationGroup = $recommendationGroup;
    }

    /**
     * @return array<string>
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function addProduct(string $product): void
    {
        if (false === $this->hasProduct($product)) {
            $this->products[] = $product;
        }
    }

    public function hasProduct(string $product): bool
    {
        return \in_array($product, $this->products, false);
    }

    public function removeProduct(string $product): void
    {
        if (true === $this->hasProduct($product)) {
            unset($this->products[\array_search($product, $this->products, false)]);

            $this->products = \array_values($this->products);
        }
    }
}
