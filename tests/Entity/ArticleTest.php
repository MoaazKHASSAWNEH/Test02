<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function getData(): array
    {
        return array(
            "titre" => "titre de l'article",
            "contenu" => "contenu de l'article", 
            "resume" => "resumé de l'article", 
            "image" => "test.png",
            "statut" => 2, 
            "slug" => "titre-de-l-article",
            "imageName" => "test2.png",
        );
    }


    public function getObjet()
    {
        $objet = new Article();

        foreach ($this->getData() as $key => $value) {
            $objet->{"set" . ucfirst($key)}($value);
        }

        return $objet;
    }

    public function testValide(): void
    {
        $article = $this->getObjet();
        $date = new \DateTime("25-01-2020"); 
        $article->setDate($date);
        $article->setUpdatedAt($date); 
        foreach ($this->getData() as $cle => $value)
            $this->assertTrue($article->{"get" . ucfirst($cle)}() === $value);
        
        $this->assertTrue($article->getDate() === $date);
        $this->assertTrue($article->getUpdatedAt() === $date); 
    }

    public function testNonValide(): void
    {
        $article = $this->getObjet();
        $date = new \DateTime("25-01-2020"); 
        $article->setDate($date);
        $article->setUpdatedAt($date); 
        foreach ($this->getData() as $cle => $value)
            $this->assertFalse($article->{"get" . ucfirst($cle)}() !== $value);
        
        $this->assertFalse($article->getDate() !== $date);
        $this->assertFalse($article->getUpdatedAt() !== $date);
    }

    public function testVide(): void
    {
        $article = new Article();

        foreach ($this->getData() as $cle => $value)
            $this->assertEmpty($article->{"get" . ucfirst($cle)}());

        $this->assertEmpty($article->getDate());
        $this->assertEmpty($article->getUpdatedAt());  
    }
}
