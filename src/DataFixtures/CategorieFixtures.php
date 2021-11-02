<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $categorie = new Categorie();
            $categorie->setTitre("Categorie $i")
                      ->setResume("C'est un résumé de la categorie $i"); 

            $manager->persist($categorie);
        }


        $manager->flush();
    }
}
