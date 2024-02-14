<?php

namespace App\Repository;

use App\Entity\Activité;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activité>
 *
 * @method Activité|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activité|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activité[]    findAll()
 * @method Activité[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivitéRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activité::class);
    }

//    /**
//     * @return Activité[] Returns an array of Activité objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Activité
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
