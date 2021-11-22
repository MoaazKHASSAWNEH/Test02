<?php

namespace App\DataFixtures;

use App\Entity\Auteur;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        
        for ($i=1;$i<=5;$i++)
        {
            $auteur = new auteur(); 
            $auteur
                ->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setEmail($faker->email)
            ;

            $manager->persist($auteur);
        }
        

        $manager->flush();
    }
}
