<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Livre;
use Faker;
use Faker\Provider\Base;


class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
            for ($i=0; $i < 10; $i++) {
            $livre = new Livre();     
            $livre->setTitre($faker->name);
            $livre->setAuteur($faker->name);
            $livre->setResume($faker->name);
            $livre->setDateParution($faker->dateTime($max = 'now', $timezone = null));
            $livre->setStatus($faker->boolean);
            $random = rand(0, 9);
            $livre->setCategory($this->getReference("category$random"));
            $livre->setBibliotheque($this->getReference("bibliotheque"));
            $manager->persist($livre);
            }
        $manager->flush();
    }
}
