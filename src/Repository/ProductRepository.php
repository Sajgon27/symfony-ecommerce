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
  public function findFeatured(): array
{
    $em = $this->getEntityManager();

    $featured = $em->createQueryBuilder()
        ->select('p')
        ->from(Product::class, 'p')
        ->where('p.isFeatured = true')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();

    $featuredCount = count($featured);

    if ($featuredCount < 10) {
        $missing = 10 - $featuredCount;

        $random = $em->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->where('p.isFeatured = false')
            ->orderBy('RAND()') 
            ->setMaxResults($missing)
            ->getQuery()
            ->getResult();

        $featured = array_merge($featured, $random);
    }

    return $featured;
}

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
