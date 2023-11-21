<?php

namespace App\Repository;

use App\Entity\Restau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restau>
 *
 * @method Restau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restau[]    findAll()
 * @method Restau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restau::class);
    }

    /**
     * @return Restau[] Returns an array of Restau objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.name = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
   /**
     * @return Restau[] Returns an array of Restau objects
     */
     public function find_nearest($lat,$log): array
     {
        $lat = floatval($lat);
        $log = floatval($log);


        return $this->createQueryBuilder('r')
        ->select('r.id ,r.name')
        ->andWhere('r.log + 0  > :val1')

        ->andWhere('r.lat + 0> :val2')
  
        ->setParameter('val1', $log)
        ->setParameter('val2', $lat)
        ->orderBy('r.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
         
     }








    
 public function moy($value): array
    {
       return $this->createQueryBuilder('c')
            ->select('c.type', 'AVG(c.price) as averagePrice')
            ->andWhere('c.type = :val')
            ->setParameter('val', $value)
            ->groupBy('c.type')
            ->getQuery()
            ->getResult()
        ;
    }














//    public function findOneBySomeField($value): ?Restau
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
