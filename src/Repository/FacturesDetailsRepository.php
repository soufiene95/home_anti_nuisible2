<?php

namespace App\Repository;

use App\Entity\FacturesDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacturesDetails>
 *
 * @method FacturesDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacturesDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacturesDetails[]    findAll()
 * @method FacturesDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturesDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacturesDetails::class);
    }

//    /**
//     * @return FacturesDetails[] Returns an array of FacturesDetails objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FacturesDetails
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
