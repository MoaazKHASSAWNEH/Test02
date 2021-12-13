<?php

namespace App\DataFixtures;

use Faker;
use APP\Entity\Auteur;
use APP\Entity\Article;
use App\Entity\Categorie;
use APP\Entity\Commentaire;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Egulias\EmailValidator\Parser\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\MakerBundle\DependencyInjection\CompilerPass\SetDoctrineAnnotatedPrefixesPass;

class ArticleFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $table_auteurs = [];
        $faker = Faker\Factory::create('fr_FR');
        for ($j = 1; $j <= 20; $j++) {
            $categorie = new Categorie();
            $categorie->setTitre($faker->sentence(6,true))
                ->setResume($faker->sentence(12, true));

            $manager->persist($categorie);
            // creation de 7 auteur
            if ($j <= 15) {
                for ($c = 1; $c <= 3; $c++) {
                    $auteur = new Auteur();
                    $auteur
                        ->setNom($faker->lastName)
                        ->setPrenom($faker->firstName)
                        ->setPassword($this->encoder->encodePassword($auteur, "momomomo"))
                        ->setEmail($faker->email);

                    $manager->persist($auteur);
                    $table_auteurs[]= $auteur;
                }
            }


            $articlesParCategorie = mt_rand(1, 200);
            for ($i = 1; $i <= $articlesParCategorie; $i++) {
                $article = new Article();
                shuffle($table_auteurs);
                $x = mt_rand(0,2); 
                $statut = ($x > 0) ? $x : null;
                $article->setTitre($faker->sentence(15,true))
                    ->setContenu($faker->sentence(150, true))
                    ->setDate($faker->dateTimeThisDecade)
                    ->setResume($faker->sentence(20, true))
                    ->setStatut($statut)
                    ->setImage("image-standard.jbeg")
                    ->setCategorie($categorie)
                    ->setAuteur($table_auteurs[0]);

                $manager->persist($article);

                $commentairesParArticle = mt_rand(0, 20);
                for ($c = 1; $c <= $commentairesParArticle; $c++) {
                    $commentaire = new Commentaire();
                    $commentaire
                        ->setAuteur($faker->firstName . " " . $faker->lastName)
                        ->setEmail($faker->email)
                        ->setDate($faker->dateTimeThisMonth())
                        ->setContenu($faker->sentence(40, true))
                        ->setArticle($article);
                    $manager->persist($commentaire);
                }
            }
        }


        $manager->flush();
    }
}
