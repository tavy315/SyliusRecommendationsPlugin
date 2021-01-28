<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;

class RecommendationGroupRepository extends EntityRepository implements RecommendationGroupRepositoryInterface
{
    public function findByNamePart(string $phrase, ?string $locale = null): array
    {
        return $this->createTranslationBasedQueryBuilder($locale)
                    ->andWhere('translation.name LIKE :name')
                    ->setParameter('name', '%' . $phrase . '%')
                    ->getQuery()
                    ->getResult();
    }

    public function findOneBySlug(string $slug, string $locale): ?RecommendationGroupInterface
    {
        return $this->createTranslationBasedQueryBuilder($locale)
                    ->andWhere('o.enabled = true')
                    ->andWhere('translation.slug = :slug')
                    ->setParameter('slug', $slug)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    private function createTranslationBasedQueryBuilder(?string $locale = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o')
                             ->addSelect('translation')
                             ->leftJoin('o.translations', 'translation');

        if (null !== $locale) {
            $queryBuilder
                ->andWhere('translation.locale = :locale')
                ->setParameter('locale', $locale);
        }

        return $queryBuilder;
    }
}
