<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Search\UserSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function get_class;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC');
    }

    /**
     * @param UserSearch $search
     * @return Query
     */
    public function findAllQuery(UserSearch $search): Query
    {
        $query = $this->findAllQueryBuilder();

        if ($search->getUsername()) {
            $query
                ->andWhere('u.username LIKE :username')
                ->setParameter('username', '%' . $search->getUsername() . '%');
        }

        if ($search->getRoles()) {
            $where = '';
            $i = 0;
            foreach ($search->getRoles() as $role) {
                if ($role === 'ROLE_USER') {
                    if (count($search->getRoles()) > 1 and $i > 0) {
                        $where .= ' OR u.roles LIKE \'[]\'';
                    } else {
                        $where .= 'u.roles LIKE \'[]\'';
                    }
                } else {
                    if (count($search->getRoles()) > 1 and $i > 0) {
                        $where .= ' OR u.roles LIKE :role';
                    } else {
                        $where .= 'u.roles LIKE :role';
                    }

                    $query->setParameter('role', '%' . $role . '%');
                }
                $i++;
            }
            $query
                ->andWhere($where);
        }

        return $query->getQuery();
    }
}
