<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Product\Repository\ProductRepositoryInterface;

class ProductRepository
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ChannelInterface $channel
     * @param string           $locale
     * @param array<string>    $products
     *
     * @return QueryBuilder
     */
    public function createShopListQueryBuilder(ChannelInterface $channel, string $locale, array $products): QueryBuilder
    {
        return $this->productRepository->createQueryBuilder('o')
                                       ->distinct()
                                       ->addSelect('translation')
                                       ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
                                       ->andWhere(':channel MEMBER OF o.channels')
                                       ->andWhere('o.enabled = true')
                                       ->andWhere('o.code IN (:codes)')
                                       ->setParameter('codes', $products)
                                       ->setParameter('locale', $locale)
                                       ->setParameter('channel', $channel);
    }
}
