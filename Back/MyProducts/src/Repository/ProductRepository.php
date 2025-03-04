<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    
    public function getProductsList(
        ?string $authorName,
        ?int $page = 1,
        ?int $amountOfPage = 6,
    ): array
    {
        $qb = $this->createQueryBuilder('product') 
        ->leftJoin('product.author', 'actor');

        if ($authorName != null) {
            $qb->andWhere('actor.code = :authorName')
            ->setParameter('authorName', $authorName);
        }

        if($page != null){
            $qb->setFirstResult(($page - 1) * $amountOfPage);
        }

        if($amountOfPage != null){
            $qb->setMaxResults($amountOfPage);
        }

        return $qb->getQuery()->getResult();
    }
}