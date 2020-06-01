<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Personne;
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
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->findAllQueryBuilder()->getQuery();
    }
}
