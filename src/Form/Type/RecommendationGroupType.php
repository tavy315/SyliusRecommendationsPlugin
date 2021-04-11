<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Tavy315\SyliusRecommendationsPlugin\Form\Type\Translation\RecommendationGroupTranslationType;

final class RecommendationGroupType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => RecommendationGroupTranslationType::class,
                'label'      => 'tavy315_sylius_recommendations.ui.name',
            ])
            ->add('position', IntegerType::class, [
                'required' => false,
                'label'    => 'tavy315_sylius_recommendations.form.recommendation_group.position',
            ])
            ->addEventSubscriber(new AddCodeFormSubscriber());
    }

    public function getBlockPrefix(): string
    {
        return 'tavy315_sylius_recommendations_recommendation_group';
    }
}
