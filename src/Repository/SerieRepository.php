<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function countGeneros(): ?array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT G.nombre, COUNT(GS.genero_id) AS num FROM genero G 
            INNER JOIN genero_serie GS ON G.id = GS.genero_id 
            INNER JOIN serie S ON S.id = GS.serie_id 
            GROUP BY GS.genero_id
            ";

        $resultSet = $conn->executeQuery($sql);

        return $resultSet->fetchAllAssociative();
    }
}
