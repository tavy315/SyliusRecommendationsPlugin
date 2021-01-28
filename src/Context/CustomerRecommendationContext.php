<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Context;

use Sylius\Component\Core\Model\ShopUser;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;
use Tavy315\SyliusRecommendationsPlugin\Factory\CustomerRecommendationFactoryInterface;
use Tavy315\SyliusRecommendationsPlugin\Repository\CustomerRecommendationRepositoryInterface;
use Tavy315\SyliusRecommendationsPlugin\Repository\RecommendationGroupRepositoryInterface;

final class CustomerRecommendationContext implements CustomerRecommendationContextInterface
{
    /** @var CustomerRecommendationFactoryInterface */
    private $customerRecommendationFactory;

    /** @var CustomerRecommendationRepositoryInterface */
    private $customerRecommendationRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var RecommendationGroupRepositoryInterface */
    private $recommendationGroupRepository;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(
        CustomerRecommendationFactoryInterface $customerRecommendationFactory,
        CustomerRecommendationRepositoryInterface $customerRecommendationRepository,
        LocaleContextInterface $localeContext,
        RecommendationGroupRepositoryInterface $recommendationGroupRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->customerRecommendationFactory = $customerRecommendationFactory;
        $this->customerRecommendationRepository = $customerRecommendationRepository;
        $this->localeContext = $localeContext;
        $this->recommendationGroupRepository = $recommendationGroupRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function getCustomerRecommendation(Request $request): CustomerRecommendationInterface
    {
        $group = $this->recommendationGroupRepository->findOneBySlug($request->attributes->get('group'), $this->localeContext->getLocaleCode());

        if ($group === null) {
            throw new NotFoundHttpException('Recommendation group has not been found.');
        }

        $token = $this->tokenStorage->getToken();

        $user = $token ? $token->getUser() : null;

        if (!($user instanceof ShopUser)) {
            return $this->customerRecommendationFactory->createNew();
        }

        return $this->customerRecommendationRepository->findByCustomer($user->getCustomer(), $group)
            ?: $this->customerRecommendationFactory->createForCustomer($user->getCustomer());
    }

    /**
     * @return array<CustomerRecommendationInterface>
     */
    public function getCustomerRecommendations(): array
    {
        $token = $this->tokenStorage->getToken();

        $user = $token ? $token->getUser() : null;

        if (!($user instanceof ShopUser)) {
            return [];
        }

        return $this->customerRecommendationRepository->findGroupsByCustomer($user->getCustomer());
    }
}
