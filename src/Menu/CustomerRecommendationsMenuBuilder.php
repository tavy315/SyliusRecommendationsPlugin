<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Util\MenuManipulator;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class CustomerRecommendationsMenuBuilder
{
    public function addCustomerRecommendationsOnCustomerPage(MenuBuilderEvent $event): void
    {
        /** @var Sylius\Bundle\AdminBundle\Event\CustomerShowMenuBuilderEvent $event */
        $menu = $event->getMenu();

        $menu
            ->addChild('customer_recommendation', [
                'route'           => 'tavy315_sylius_recommendations_admin_customer_customer_recommendation',
                'routeParameters' => [ 'id' => $event->getCustomer()->getId() ],
            ])
            ->setAttribute('type', 'show')
            ->setLabel('tavy315_sylius_recommendations.ui.show_recommendations');

        $manipulator = new MenuManipulator();
        $manipulator->moveToPosition($menu['customer_recommendation'], 1);
    }

    public function addCustomerRecommendationsOnMainPanel(MenuBuilderEvent $event): void
    {
        /** @var ItemInterface $customersMenu */
        $customersMenu = $event->getMenu()->getChild('customers');

        $customersMenu->addChild('customer_recommendations', [ 'route' => 'tavy315_sylius_recommendations_admin_customer_recommendation_index' ])
                      ->setLabel('tavy315_sylius_recommendations.ui.customer_recommendations')
                      ->setLabelAttribute('icon', 'newspaper');

        $customersMenu->addChild('recommendation_groups', [ 'route' => 'tavy315_sylius_recommendations_admin_recommendation_group_index' ])
                      ->setLabel('tavy315_sylius_recommendations.ui.recommendation_groups')
                      ->setLabelAttribute('icon', 'newspaper');
    }
}
