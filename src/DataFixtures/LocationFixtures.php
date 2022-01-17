<?php

namespace App\DataFixtures;

use Faker;

use App\Entity\Location;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class LocationFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $status = ["En core", "Terminé", "Demandé"];
        $faker = Faker\Factory::create('fr_FR');
        for ($i=1;$i<=1000;$i++) {
            // $x = mt_rand(0,1);
            // if ($x == 0) $acc = false; else $acc=true;
            shuffle($status);

            $loc = new Location(); 
            $loc
                ->setDate($faker->dateTimeThisDecade)
                ->setTitre($faker->sentence(6,true))
                ->setCategorie($faker->sentence(3,true))
                ->setImage("image_location.jpg")
                ->setDescription($faker->sentence(30,true))
                ->setValeur(round(mt_rand(10,300),2))
                ->setAdresse($faker->address)
                ->setAccessibility($faker->boolean())
                ->setStatut($status[0])
                ->setPremierePage($faker->boolean(40))
            ;
            $manager->persist($loc);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}
