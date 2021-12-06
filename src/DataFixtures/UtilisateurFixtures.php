<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;

class UtilisateurFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName)
                        ->setPrenom($faker->firstName)
                        ->setLogin("user$i")
                        ->setEmail($faker->email)
                        ->setPassword($this->encoder->encodePassword($utilisateur,"momomomo"))
                        ->setAdresse($faker->address)
                        ->setDateNaissance($faker->dateTimeBetween())
                        ->setPhoto("user.jpg")
                    ;

            $manager->persist($utilisateur);
        }


        $manager->flush();
    }
}
