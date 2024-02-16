<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Controller\Action;

use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tavy315\SyliusRecommendationsPlugin\Context\CustomerRecommendationContextInterface;
use Tavy315\SyliusRecommendationsPlugin\Repository\ProductRepositoryInterface;
use Tavy315\SyliusRecommendationsPlugin\RequestDataHandler\PaginationDataHandlerInterface;
use Twig\Environment;

final class ListRecommendationProductsAction
{
    public function __construct(
        private CustomerRecommendationContextInterface $customerRecommendationContext,
        private ProductRepositoryInterface $productRepository,
        private Environment $twig,
        private PaginationDataHandlerInterface $paginationDataHandler,
        private ShopperContextInterface $shopperContext
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $paginationData = $this->paginationDataHandler->retrieveData($request->query->all());
        $customerRecommendation = $this->customerRecommendationContext->getCustomerRecommendation($request);

        $queryBuilder = $this->productRepository->createShopListQueryBuilder(
            $this->shopperContext->getChannel(),
            $this->shopperContext->getLocaleCode(),
            $customerRecommendation->getProducts()
        );

        $results = new Pagerfanta(new QueryAdapter($queryBuilder, false, false));
        $results->setCurrentPage($paginationData[PaginationDataHandlerInterface::PAGE_INDEX]);
        $results->setMaxPerPage($paginationData[PaginationDataHandlerInterface::LIMIT_INDEX]);

        return new Response($this->twig->render('@Tavy315SyliusRecommendationsPlugin/products.html.twig', [
            'group'    => $customerRecommendation->getRecommendationGroup(),
            'products' => $results,
        ]));
    }
}
