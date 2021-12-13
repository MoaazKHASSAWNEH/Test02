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
            ->setCivilite("M.")
            ->setNom("KHASSAWNEH")
            ->setPrenom("Moaaz")
            ->setDateNaissance(new \DateTime("29-03-1995"))
            ->setEmail("momo@admin.com")
            ->setLogin("momo.95")
            ->setPassword($this->encoder->encodePassword($sup_admin,"momomomo"))
            ->setAdresse("3 Place d'Angleterre 54500 Vandoeuvre-les-Nancy")
            ->setPhoto("momo.jpg")
            ->setRoles(["ROLE_SUPER_ADMIN","ROLE_ADMIN","ROLE_AUTEUR"])
            ->setStatut(null)
        ;
        $manager->persist($sup_admin);

        //Creation des utilisateurs sur le site
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 199; $i++) {
            $utilisateur = new Utilisateur();
            $civilite = (mt_rand(0,1) == 0) ? "Mme" : "M.";
            $prenom = ($civilite == "Mme") ? $faker->firstNameFemale : $faker->firstNameMale;
            $x = mt_rand(0,2); 
            $statut = null; 
            if ($x>0)
                $statut = $x; 
            
            $utilisateur->setNom($faker->lastName)
                        ->setCivilite($civilite)
                        ->setPrenom($prenom)
                        ->setLogin($faker->userName)
                        ->setEmail($faker->email)
                        ->setPassword($this->encoder->encodePassword($utilisateur,"momomomo"))
                        ->setAdresse($faker->address)
                        ->setDateNaissance($faker->dateTimeBetween())
                        ->setPhoto("user.jpg")
                        ->setStatut($statut)
                    ;

            $manager->persist($utilisateur);
        }


        $manager->flush();
    }
}
