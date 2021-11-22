<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentaireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        
        for ($i=1;$i<=200;$i++)
        {
            $commentaire = new commentaire(); 
            $commentaire
                ->setAuteur($faker->lastName . " " . $faker->firstName)
                ->setEmail($faker->email)
                ->setDate($faker->dateTimeThisYear)
                ->setContenu($faker->sentence(20,true))
            ;

            $manager->persist($commentaire);
        }
        

        $manager->flush();
    }
}
