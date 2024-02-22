<?php

namespace App\Repository;

use App\Entity\Lista;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lista>
 *
 * @method Lista|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lista|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lista[]    findAll()
 * @method Lista[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lista::class);
    }

    public function listaSeriesPorVer($usuario): ?Lista
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.usuario = :usuario')
            ->andWhere('l.tipo_lista = :lista')
            ->setParameter('usuario', $usuario)
            ->setParameter('lista', 'series_por_ver')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function listaSeriesViendo($usuario): ?Lista
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.usuario = :usuario')
            ->andWhere('l.tipo_lista = :lista')
            ->setParameter('usuario', $usuario)
            ->setParameter('lista', 'series_viendo')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function listaSeriesVistas($usuario): ?Lista
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.usuario = :usuario')
            ->andWhere('l.tipo_lista = :lista')
            ->setParameter('usuario', $usuario)
            ->setParameter('lista', 'series_vistas')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function listaSeriesFavoitas($usuario): ?Lista
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.usuario = :usuario')
            ->andWhere('l.tipo_lista = :lista')
            ->setParameter('usuario', $usuario)
            ->setParameter('lista', 'series_favoritas')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
