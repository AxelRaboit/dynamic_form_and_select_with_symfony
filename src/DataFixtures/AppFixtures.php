<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //FRANCE

        $france = new Country();
        $france->setName('France');

        $paris = new City();
        $paris->setName('Paris');
        $paris->setCountry($france);
        $manager->persist($paris);

        $marseille = new City();
        $marseille->setName('Marseille');
        $marseille->setCountry($france);
        $manager->persist($marseille);

        $toulouse = new City();
        $toulouse->setName('Toulouse');
        $toulouse->setCountry($france);
        $manager->persist($toulouse);

        $lyon = new City();
        $lyon->setName('Lyon');
        $lyon->setCountry($france);
        $manager->persist($lyon);

        $reims = new City();
        $reims->setName('Reims');
        $reims->setCountry($france);
        $manager->persist($reims);

        $epernay = new City();
        $epernay->setName('Epernay');
        $epernay->setCountry($france);
        $manager->persist($epernay);

        $nantes = new City();
        $nantes->setName('Nantes');
        $nantes->setCountry($france);
        $manager->persist($nantes);

        //CANADA

        $canada = new Country();
        $canada->setName('Canada');

        $quebec = new City();
        $quebec->setName('Quebec');
        $quebec->setCountry($canada);
        $manager->persist($quebec);

        $toronto = new City();
        $toronto->setName('Toronto');
        $toronto->setCountry($canada);
        $manager->persist($toronto);

        $ottawa = new City();
        $ottawa->setName('Ottawa');
        $ottawa->setCountry($canada);
        $manager->persist($ottawa);

        $joliette = new City();
        $joliette->setName('Joliette');
        $joliette->setCountry($canada);
        $manager->persist($joliette);

        $montreal = new City();
        $montreal->setName('Montréal');
        $montreal->setCountry($canada);
        $manager->persist($montreal);

        $vancouver = new City();
        $vancouver->setName('Vancouver');
        $vancouver->setCountry($canada);
        $manager->persist($vancouver);

        $troisrivieres = new City();
        $troisrivieres->setName('Trois rivières');
        $troisrivieres->setCountry($canada);
        $manager->persist($troisrivieres);


        $manager->flush();
    }
}
