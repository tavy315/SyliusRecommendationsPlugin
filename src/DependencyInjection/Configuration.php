<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendation;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroup;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupTranslation;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupTranslationInterface;
use Tavy315\SyliusRecommendationsPlugin\Form\Type\CustomerRecommendationType;
use Tavy315\SyliusRecommendationsPlugin\Form\Type\RecommendationGroupType;
use Tavy315\SyliusRecommendationsPlugin\Form\Type\Translation\RecommendationGroupTranslationType;
use Tavy315\SyliusRecommendationsPlugin\Repository\CustomerRecommendationRepository;
use Tavy315\SyliusRecommendationsPlugin\Repository\RecommendationGroupRepository;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('tavy315_sylius_recommendations');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end();
        $rootNode
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('customer_recommendation')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(CustomerRecommendationType::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(CustomerRecommendationInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('model')->defaultValue(CustomerRecommendation::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(CustomerRecommendationRepository::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('recommendation_group')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(RecommendationGroupType::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(RecommendationGroupInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('model')->defaultValue(RecommendationGroup::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(RecommendationGroupRepository::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('classes')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('form')->defaultValue(RecommendationGroupTranslationType::class)->cannotBeEmpty()->end()
                                                ->scalarNode('interface')->defaultValue(RecommendationGroupTranslationInterface::class)->cannotBeEmpty()->end()
                                                ->scalarNode('model')->defaultValue(RecommendationGroupTranslation::class)->cannotBeEmpty()->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
