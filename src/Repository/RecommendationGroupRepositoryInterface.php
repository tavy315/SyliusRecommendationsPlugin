<?php

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;

interface RecommendationGroupRepositoryInterface extends RepositoryInterface
{
    public function findOneBySlug(string $slug, string $locale): ?RecommendationGroupInterface;
}
