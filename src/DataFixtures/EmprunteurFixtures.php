<?php

namespace App\DataFixtures;
use App\Entity\Emprunteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Provider\Base;


class EmprunteurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i < 10; $i++) {
        $emprunteur = new Emprunteur();     
        $emprunteur->setNumero($faker->numberBetween(1,200));
        $emprunteur->setNom($faker->lastName);
        $emprunteur->setPrenom($faker->firstName);
        $manager->persist($emprunteur);
        }
    $manager->flush();
    }
}
