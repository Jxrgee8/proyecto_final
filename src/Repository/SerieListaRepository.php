<?php

namespace App\Repository;

use App\Entity\SerieLista;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SerieLista>
 *
 * @method SerieLista|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerieLista|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerieLista[]    findAll()
 * @method SerieLista[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieListaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerieLista::class);
    }

//    /**
//     * @return SerieLista[] Returns an array of SerieLista objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SerieLista
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
