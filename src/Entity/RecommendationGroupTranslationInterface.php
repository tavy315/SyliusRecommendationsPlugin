<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface RecommendationGroupTranslationInterface extends SlugAwareInterface, ResourceInterface, TranslationInterface
{
    public function getName(): ?string;

    public function setName(string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}
