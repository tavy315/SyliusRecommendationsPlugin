<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Form\Type;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;

final class RecommendationGroupChoiceType extends AbstractType
{
    /** @var RepositoryInterface */
    private $recommendationGroupRepository;

    public function __construct(RepositoryInterface $recommendationGroupRepository)
    {
        $this->recommendationGroupRepository = $recommendationGroupRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['multiple']) {
            $builder->addModelTransformer(new CollectionToArrayTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices'                   => function (Options $options): array {
                return $this->recommendationGroupRepository->findAll();
            },
            'choice_value'              => 'code',
            'choice_label'              => function (RecommendationGroupInterface $recommendationGroup): string {
                return sprintf('%s (%s)', $recommendationGroup->getName(), $recommendationGroup->getCode());
            },
            'choice_translation_domain' => false,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'tavy315_sylius_recommendations_recommendation_group_choice';
    }
}
