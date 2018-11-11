<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tarifs;

class TarifsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tarif = new Tarifs();
        $tarif->setTypeTarif("Normal");
        $tarif->setTarif(16);
        $tarif2 = new Tarifs();
        $tarif2->setTypeTarif("Enfants");
        $tarif2->setTarif(8);
        $tarif3 = new Tarifs();
        $tarif3->setTypeTarif("Séniors");
        $tarif3->setTarif(12);
        $tarif4 = new Tarifs();
        $tarif4->setTypeTarif("Réduit");
        $tarif4->setTarif(10);
        $manager->persist($tarif);
        $manager->persist($tarif2);
        $manager->persist($tarif3);
        $manager->persist($tarif4);

        $manager->flush();
    }
}
