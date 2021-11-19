<?php

namespace App\DataFixtures;

use APP\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
            
            $articlesParCategorie = mt_rand(1,20); 
            for ($i=1; $i<=$articlesParCategorie; $i++){
                $article = new Article();
                $article->setTitre($faker->sentence())
                    ->setContenu($faker->sentence(40,true))
                    ->setDate(new \DateTime())
                    ->setResume($faker->sentence(12,true))
                    ->setImage("image-standard.jbeg")
                    ->setCategorie($categorie)
                ;    
                $manager->persist($article);
            }
        }

        
        $manager->flush();
    }
}
