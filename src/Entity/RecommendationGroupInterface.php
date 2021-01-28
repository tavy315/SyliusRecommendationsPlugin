<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Entity;

use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface RecommendationGroupInterface extends CodeAwareInterface, TranslatableInterface, ResourceInterface, SlugAwareInterface, ToggleableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getPosition(): ?int;

    public function setPosition(?int $position): void;

    /**
     * @param string|null $locale
     *
     * @return RecommendationGroupTranslationInterface
     */
    public function getTranslation(?string $locale = null): TranslationInterface;
}
