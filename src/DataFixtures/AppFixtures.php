<?php 

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $livre = new Livre();
            $livre->setTitre('livre '.$i);
            $livre->setAuteur('livre '.$i);
            $livre->setResume('livre '.$i);
            $livre->setStatus(1);
            $livre->setDateParution();
            $manager->persist($livre);
        }

        $manager->flush();
    }
}