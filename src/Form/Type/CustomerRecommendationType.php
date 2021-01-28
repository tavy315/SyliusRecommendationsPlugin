<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Form\Type;

use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CustomerRecommendationType extends AbstractResourceType
{
    /** @var DataTransformerInterface */
    private $productsToCodesTransformer;

    /** @var ?ChoiceLoaderInterface|null */
    private $recommendationGroupChoiceLoader;

    public function __construct(
        string $dataClass,
        DataTransformerInterface $productsToCodesTransformer,
        array $validationGroups = [],
        ?ChoiceLoaderInterface $recommendationGroupChoiceLoader = null
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->productsToCodesTransformer = $productsToCodesTransformer;
        $this->recommendationGroupChoiceLoader = $recommendationGroupChoiceLoader;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', CustomerAutocompleteChoiceType::class, [
                'label'       => 'sylius.ui.customer',
                'placeholder' => 'tavy315_sylius_recommendations.ui.select_customer',
                'multiple'    => false,
                'required'    => true,
            ])
            ->add('recommendationGroup', RecommendationGroupChoiceType::class, [
                'choice_loader' => $this->recommendationGroupChoiceLoader,
                'constraints'   => [
                    new NotBlank([ 'groups' => [ 'sylius' ] ]),
                ],
                'label'         => 'tavy315_sylius_recommendations.ui.recommendation_group',
                'placeholder'   => 'tavy315_sylius_recommendations.ui.select_recommendation_group',
            ])
            ->add('products', ProductAutocompleteChoiceType::class, [
                'multiple' => true,
            ]);

        $builder->get('products')->addModelTransformer($this->productsToCodesTransformer);
    }

    public function getBlockPrefix(): string
    {
        return 'tavy315_sylius_customer_recommendations_plugin_customer_recommendation';
    }
}
