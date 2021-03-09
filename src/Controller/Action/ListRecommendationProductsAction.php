<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Controller\Action;

use Pagerfanta\Adapter\DoctrineORMAdapter;
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
    /** @var CustomerRecommendationContextInterface */
    private $customerRecommendationContext;

    /** @var PaginationDataHandlerInterface */
    private $paginationDataHandler;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ShopperContextInterface */
    private $shopperContext;

    /** @var Environment */
    private $twig;

    public function __construct(
        CustomerRecommendationContextInterface $recommendationContext,
        ProductRepositoryInterface $productRepository,
        Environment $twig,
        PaginationDataHandlerInterface $paginationDataHandler,
        ShopperContextInterface $shopperContext
    ) {
        $this->customerRecommendationContext = $recommendationContext;
        $this->paginationDataHandler = $paginationDataHandler;
        $this->productRepository = $productRepository;
        $this->shopperContext = $shopperContext;
        $this->twig = $twig;
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

        $results = new Pagerfanta(new DoctrineORMAdapter($queryBuilder, false, false));
        $results->setCurrentPage($paginationData[PaginationDataHandlerInterface::PAGE_INDEX]);
        $results->setMaxPerPage($paginationData[PaginationDataHandlerInterface::LIMIT_INDEX]);

        return new Response($this->twig->render('@Tavy315SyliusRecommendationsPlugin/products.html.twig', [
            'group'    => $customerRecommendation->getRecommendationGroup(),
            'products' => $results,
        ]));
    }
}
