<?php

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getPariteEspece(Espece $espece)
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

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
