<?php

namespace App\Repository;

use App\Entity\Capitulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Capitulos>
 *
 * @method Capitulos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capitulos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capitulos[]    findAll()
 * @method Capitulos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapituloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capitulo::class);
    }

//    /**
//     * @return Capitulos[] Returns an array of Capitulos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Capitulos
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
