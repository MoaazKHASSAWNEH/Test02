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
        // Creation de profile super admin
        $sup_admin = new Utilisateur();
        $sup_admin
            ->setNom("KHASSAWNEH")
            ->setPrenom("Moaaz")
            ->setDateNaissance(new \DateTime("29-03-1995"))
            ->setEmail("momo@admin.com")
            ->setLogin("momo.95")
            ->setPassword($this->encoder->encodePassword($sup_admin,"momomomo"))
            ->setAdresse("3 Place d'Angleterre 54500 Vandoeuvre-les-Nancy")
            ->setPhoto("momo.jpg")
            ->setRoles(["ROLE_SUPER_ADMIN","ROLE_ADMIN","ROLE_AUTEUR"])
        ;
        $manager->persist($sup_admin);

        //Creation des utilisateurs sur le site
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 199; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName)
                        ->setPrenom($faker->firstName)
                        ->setLogin($faker->userName)
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
