<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Faker;
use Faker\Provider\Base;
use App\DataFixtures\BibliothequeFixtures;

class UserFixtures extends Fixture

{

    private $passwordEncoder;

         public function __construct(UserPasswordEncoderInterface $passwordEncoder)
         {
             $this->passwordEncoder = $passwordEncoder;
         }
    
    public function load(ObjectManager $manager)
    {
            $faker = Faker\Factory::create('fr_FR');
            for ($i=0; $i < 10; $i++) {
            $user = new User();     
            $user->setBibliotheque($this->getReference('bibliotheque'));
            $user->setUsername($faker->name);
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
