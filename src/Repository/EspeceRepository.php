<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Search\EspeceSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Espece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espece[]    findAll()
 * @method Espece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspeceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espece::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nom', 'ASC');
    }

    /**
     * @param EspeceSearch $search
     * @return Query
     */
    public function findAllQuery(EspeceSearch $search): Query
    {
        $query = $this->findAllQueryBuilder();

        if ($search->getNom()) {
            $query
                ->andWhere('e.nom LIKE :nom')
                ->setParameter('nom', '%' . $search->getNom() . '%');
        }

        return $query->getQuery();
    }
}
