<?php

namespace App\DataFixtures;

use APP\Entity\Article;
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
        for ($i=1;$i<=20;$i++){
            $article = new Article();
            $article->setTitre($faker->sentence())
                    ->setContenu($faker->sentence($nbWords = 20, $variableNbWords = true))
                    ->setDate(new \DateTime())
                    ->setResume($faker->sentence($nbWords = 10, $variableNbWords = true))
                    ->setImage("image-standard.jbeg");
                    
            $manager->persist($article);
        }
        
        

        $manager->flush();
    }
}
