<?php

namespace App\Tests\Entity;

use App\Entity\Categorie;
use PhpParser\Node\Stmt\Catch_;
use PHPUnit\Framework\TestCase;

class CategorieTest extends TestCase
{
    public function getData(): array
    {
        return array(
            "titre" => "Titre de la categorie",
            "resume" => "Voici le résumé de l'article",
        );
    }


    public function getObjet()
    {
        $objet = new Categorie();

        foreach ($this->getData() as $key => $value) {
            $objet->{"set" . ucfirst($key)}($value);
        }

        return $objet;
    }

    public function testValide(): void
    {
        $categorie = $this->getObjet();
        
        foreach ($this->getData() as $cle => $value)
            $this->assertTrue($categorie->{"get" . ucfirst($cle)}() === $value);
     
    }

    public function testNonValide(): void
    {
        $categorie = $this->getObjet();
        
        foreach ($this->getData() as $cle => $value)
            $this->assertFalse($categorie->{"get" . ucfirst($cle)}() !== $value);

    }

    public function testVide(): void
    {
        $categorie = new Categorie();

        foreach ($this->getData() as $cle => $value)
            $this->assertEmpty($categorie->{"get" . ucfirst($cle)}());

    }
}
