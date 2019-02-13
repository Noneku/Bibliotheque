<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
class Userfixtures extends Fixture
{
    private $passwordEncoder;

         public function __construct(UserPasswordEncoderInterface $passwordEncoder)
         {
             $this->passwordEncoder = $passwordEncoder;
         }
    
    public function load(ObjectManager $manager)
    {
            for ($i=0; $i < 10; $i++) {
            $user = new User();     
            $user->setUsername("vincent$i");
            $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            "password$i"
            ));
            $user->setRoles(["ROLE_BIBLIOTHECAIRE"]);
            $manager->persist($user);
         }
        $manager->flush();

    }
}
