<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Secrétaire
        $user = new User();
        $user->setUsername('sec');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'sec'
        ));
        $user->setRoles(['ROLE_SECRETAIRE']);
        $manager->persist($user);

        // Administrateur
        $user = new User();
        $user->setUsername('adm');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'adm'
        ));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // User normal
        $user = new User();
        $user->setUsername('foo');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'bar'
        ));
        $manager->persist($user);


        $manager->flush();
    }
}
