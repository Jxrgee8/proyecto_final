<?php

namespace App\Repository;

use App\Entity\Plataforma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plataforma>
 *
 * @method Plataforma|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plataforma|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plataforma[]    findAll()
 * @method Plataforma[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlataformaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plataforma::class);
    }

    public function buscarPlataforma($plataforma): ?Plataforma
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nombre = :plataforma')
            ->setParameter('plataforma', $plataforma)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
