<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Customer\Model\CustomerInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\CustomerRecommendationInterface;
use Tavy315\SyliusRecommendationsPlugin\Entity\RecommendationGroupInterface;

class CustomerRecommendationRepository extends EntityRepository implements CustomerRecommendationRepositoryInterface
{
    public function findByCustomer(CustomerInterface $customer, RecommendationGroupInterface $group): ?CustomerRecommendationInterface
    {
        return $this->createQueryBuilder('r')
                    ->where('r.customer = :customer')
                    ->andWhere('r.recommendationGroup = :group')
                    ->setParameter('customer', $customer)
                    ->setParameter('group', $group)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function findOneByCustomerAndRecommendationGroup(string $customerId, string $recommendationGroupCode): ?CustomerRecommendationInterface
    {
        return $this->createQueryBuilder('r')
                    ->addSelect('customer')
                    ->innerJoin(RecommendationGroupInterface::class, 'g', Join::WITH, 'r.recommendationGroup = g.id')
                    ->leftJoin('r.customer', 'customer')
                    ->where('r.customer = :customerId')
                    ->andWhere('g.code = :code')
                    ->andWhere('g.enabled = true')
                    ->setParameter('customerId', $customerId)
                    ->setParameter('code', $recommendationGroupCode)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @return array<CustomerRecommendationInterface>
     */
    public function findGroupsByCustomer(CustomerInterface $customer): array
    {
        return $this->createQueryBuilder('r')
                    ->innerJoin(RecommendationGroupInterface::class, 'g', Join::WITH, 'r.recommendationGroup = g.id')
                    ->where('r.customer = :customer')
                    ->andWhere('g.enabled = true')
                    ->setParameter('customer', $customer)
                    ->orderBy('g.position', self::ORDER_ASCENDING)
                    ->getQuery()
                    ->getResult();
    }

    public function findGroupsByCustomerId(string $customerId): QueryBuilder
    {
        return $this->createQueryBuilder('r')
                    ->addSelect('customer')
                    ->innerJoin(RecommendationGroupInterface::class, 'g', Join::WITH, 'r.recommendationGroup = g.id')
                    ->leftJoin('r.customer', 'customer')
                    ->where('r.customer = :customerId')
                    ->andWhere('g.enabled = true')
                    ->setParameter('customerId', $customerId)
                    ->orderBy('g.position', self::ORDER_ASCENDING);
    }
}
