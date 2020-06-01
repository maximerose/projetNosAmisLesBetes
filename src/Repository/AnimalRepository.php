<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Adresse;
use App\Entity\Animal;
use App\Entity\Search\AnimalSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function getMoyenneAge(Adresse $adresse): float
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->select('AVG(a.age)')
            ->innerJoin('a.maitres', 'p', 'WITH', 'p.adresse = :adresse')
            ->setParameter('adresse', $adresse->getId());

        try {
            return round($qb->getQuery()->getSingleScalarResult(), 2);
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        return 0;
    }


    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.nom', 'ASC');
    }

    /**
     * @param AnimalSearch $search
     * @return Query
     */
    public function findAllQuery(AnimalSearch $search): Query
    {
        $query = $this->findAllQueryBuilder()
            ->select('p', 'a')
            ->join('a.maitres', 'p');

        if ($search->getNom()) {
            $query
                ->andWhere('a.nom LIKE :nom')
                ->setParameter('nom', '%' . $search->getNom() . '%');
        }

        if ($search->getMinAge()) {
            $query
                ->andWhere('a.age >= :minAge')
                ->setParameter('minAge', $search->getMinAge());
        }

        if ($search->getMaxAge()) {
            $query
                ->andWhere('a.age <= :maxAge')
                ->setParameter('maxAge', $search->getMaxAge());
        }

        if ($search->getEspeces()) {
            $query
                ->andWhere('a.espece IN (:especes)')
                ->setParameter('especes', $search->getEspeces());
        }

        if ($search->getMaitres()) {
            $query
                ->andWhere('p IN (:maitres)')
                ->setParameter('maitres', $search->getMaitres());
        }

        return $query->getQuery();
    }

}
