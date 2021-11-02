<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName)
                        ->setPrenom($faker->firstName)
                        ->setLogin("user$i")
                        ->setEmail($faker->email)
                        ->setPassword("user$i")
                        ->setAdresse($faker->address)
                        ->setDateNaissance($faker->dateTimeBetween())
                        ->setPhoto("user.jpg")
                        ->setRole("user");

            $manager->persist($utilisateur);
        }


        $manager->flush();
    }
}
