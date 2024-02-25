<?php

namespace App\Repository;

use App\Entity\Streaming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Streaming>
 *
 * @method Streaming|null find($id, $lockMode = null, $lockVersion = null)
 * @method Streaming|null findOneBy(array $criteria, array $orderBy = null)
 * @method Streaming[]    findAll()
 * @method Streaming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Streaming::class);
    }

    public function buscarStreaming($streaming): ?Streaming
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nombre = :streaming')
            ->setParameter('streaming', $streaming)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
