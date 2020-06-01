<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Adresse;
use App\Entity\Search\AdresseSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adresse[]    findAll()
 * @method Adresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.intitule', 'ASC');
    }

    /**
     * @param AdresseSearch $search
     * @return Query
     */
    public function findAllQuery(AdresseSearch $search): Query
    {
        $query = $this->findAllQueryBuilder();

        if ($search->getIntitule()) {
            $query
                ->andWhere('a.intitule LIKE :intitule')
                ->setParameter('intitule', '%' . $search->getIntitule() . '%');
        }

        return $query->getQuery();
    }
}
