<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Controller\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tavy315\SyliusRecommendationsPlugin\Context\CustomerRecommendationContextInterface;
use Twig\Environment;

final class ListRecommendationGroupsAction
{
    /** @var CustomerRecommendationContextInterface */
    private $customerRecommendationContext;

    /** @var Environment */
    private $twig;

    public function __construct(CustomerRecommendationContextInterface $recommendationContext, Environment $twig)
    {
        $this->customerRecommendationContext = $recommendationContext;
        $this->twig = $twig;
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->twig->render('@Tavy315SyliusRecommendationsPlugin/groups.html.twig', [
            'recommendations' => $this->customerRecommendationContext->getCustomerRecommendations(),
        ]));
    }
}
