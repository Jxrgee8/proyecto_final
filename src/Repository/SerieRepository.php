<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    /**
     * @return Serie[]
     */
    public function buscarPorGenero(string $genero): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            '
            SELECT s
            FROM App\Entity\Serie s
            WHERE s.genero > :genero
            '
        )->setParameter('genero', $genero);

        // returns Tarea[]
        return $query->getResult();
    }

}
