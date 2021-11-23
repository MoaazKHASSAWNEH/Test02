<?php

namespace App\DataFixtures;

use APP\Entity\Article;
use APP\Entity\Auteur;
use APP\Entity\Commentaire;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Egulias\EmailValidator\Parser\Comment;
use Symfony\Bundle\MakerBundle\DependencyInjection\CompilerPass\SetDoctrineAnnotatedPrefixesPass;
use Faker; 

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($j=1; $j<=10; $j++)
        {
            $categorie = new Categorie();
            $categorie->setTitre($faker->sentence())
                ->setResume($faker->sentence(12,true))
            ;

            $manager->persist($categorie); 
            // creation de 7 auteur
            if ($j<=7)
            {
                $auteur = new Auteur(); 
                $auteur
                    ->setNom($faker->lastName)
                    ->setPrenom($faker->firstName)
                    ->setEmail($faker->email)
                ;

                $manager->persist($auteur);
            }


            $articlesParCategorie = mt_rand(1,20); 
            for ($i=1; $i<=$articlesParCategorie; $i++){
                $article = new Article();
                $article->setTitre($faker->sentence())
                    ->setContenu($faker->sentence(40,true))
                    ->setDate(new \DateTime())
                    ->setResume($faker->sentence(12,true))
                    ->setImage("image-standard.jbeg")
                    ->setCategorie($categorie)
                    ->setAuteur($auteur)
                ;
                
                $manager->persist($article);

                $commentairesParArticle = mt_rand(0,15); 
                for ($c=1;$c<=$commentairesParArticle;$c++)
                {
                    $commentaire = new Commentaire(); 
                    $commentaire 
                        ->setAuteur($faker->firstName . " " . $faker->lastName)
                        ->setEmail($faker->email)
                        ->setDate($faker->dateTimeThisMonth())
                        ->setContenu($faker->sentence(20, true))
                        ->setArticle($article)
                    ;
                    $manager->persist($commentaire); 
                }
            }
        }

        
        $manager->flush();
    }
}
