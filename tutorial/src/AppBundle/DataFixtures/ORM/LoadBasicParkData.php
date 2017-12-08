<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBasicParkData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $carnivorousEnclosure = new Enclosure();
        $manager->persist($carnivorousEnclosure);
        $this->addReference('carnivorous-enclosure', $carnivorousEnclosure);

        $herbivorousEnclosure = new Enclosure();
        $manager->persist($herbivorousEnclosure);
        $this->addReference('herbivorous-enclosure', $herbivorousEnclosure);

        $manager->persist(new Enclosure(true));

        $this->addDinosaur($manager, $carnivorousEnclosure, 'Velociraptor', true, 3);
        $this->addDinosaur($manager, $carnivorousEnclosure, 'Velociraptor', true, 1);
        $this->addDinosaur($manager, $carnivorousEnclosure, 'Velociraptor', true, 5);

        $this->addDinosaur($manager, $herbivorousEnclosure, 'Triceratops', false, 7);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

    private function addDinosaur(
        ObjectManager $manager,
        Enclosure $enclosure,
        string $genus,
        bool $isCarnivorous,
        int $length
    )
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setEnclosure($enclosure);
        $dinosaur->setLength($length);

        $manager->persist($dinosaur);
    }
}
