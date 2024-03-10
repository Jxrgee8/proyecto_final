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

    public function getSerieIdFromLista($lista_id): ?array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT serie_id FROM serie_lista sl
            WHERE sl.lista_id = :lista_id
            ';

        $resultSet = $conn->executeQuery($sql, ['lista_id' => $lista_id]);
        
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function buscarSerieExisteEnLista($lista_id, $serie_id): ?array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM serie_lista sl
            WHERE sl.lista_id = :lista_id
            AND sl.serie_id = :serie_id
            ';

        $resultSet = $conn->executeQuery($sql, ['lista_id' => $lista_id, 'serie_id' => $serie_id]);
        
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

}
