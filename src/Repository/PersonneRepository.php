<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Personne;
use App\Entity\Search\PersonneSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    /**
     * @param Espece $espece
     * @return array
     */
    public function getPariteEspece(Espece $espece): array
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('p.animaux', 'a', 'WITH', 'a.espece = :espece')
            ->andWhere('p.sexe = :sexe')
            ->setParameter('espece', $espece->getId());

        $data['hommes'] = count($qb->setParameter('sexe', 'M')->getQuery()->getResult());
        $data['femmes'] = count($qb->setParameter('sexe', 'F')->getQuery()->getResult());
        $data['total'] = $data['hommes'] + $data['femmes'];

        return $data;
    }

    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.nom', 'ASC');
    }

    /**
     * @param PersonneSearch $search
     * @return Query
     */
    public function findAllQuery(PersonneSearch $search): Query
    {
        $query = $this->findAllQueryBuilder()
            ->select('a', 'p')
            ->join('p.animaux', 'a');

        if ($search->getNom()) {
            $query
                ->andWhere('p.nom LIKE :nom')
                ->setParameter('nom', '%' . $search->getNom() . '%');
        }

        if ($search->getMinAge()) {
            $query
                ->andWhere('p.age >= :minAge')
                ->setParameter('minAge', $search->getMinAge());
        }

        if ($search->getMaxAge()) {
            $query
                ->andWhere('p.age <= :maxAge')
                ->setParameter('maxAge', $search->getMaxAge());
        }

        if ($search->getSexes()) {
            $query
                ->andWhere('p.sexe IN (:sexes)')
                ->setParameter('sexes', $search->getSexes());
        }

        if ($search->getAdresses()) {
            $query
                ->andWhere('p.adresse IN (:adresses)')
                ->setParameter('adresses', $search->getAdresses());
        }

        if ($search->getAnimaux()) {
            $query
                ->andWhere('a IN (:animaux)')
                ->setParameter('animaux', $search->getAnimaux());
        }

        return $query->getQuery();
    }
}
