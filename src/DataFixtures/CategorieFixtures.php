<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategorieFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');   
        for ($i = 1 ; $i <= 1500 ; $i++){
            $categorie = new Categorie();
            $categorie->setTitre($faker->sentence(6,true))
                ->setResume($faker->sentence(12, true));

            $manager->persist($categorie);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group3'];
    }
}
