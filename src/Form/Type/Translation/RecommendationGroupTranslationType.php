<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Form\Type\Translation;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class RecommendationGroupTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'tavy315_sylius_recommendations.ui.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'tavy315_sylius_recommendations.ui.slug',
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'tavy315_sylius_recommendations_recommendation_group_translation';
    }
}
