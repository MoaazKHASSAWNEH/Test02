<?php

namespace App\Tests\Entity;

use App\Entity\Auteur;
use PhpParser\Node\Stmt\Catch_;
use PHPUnit\Framework\TestCase;

class AuteurTest extends TestCase
{
    public function getData(): array
    {
        return array(
            "nom" => "khassawneh",
            "prenom" => "moaaz", 
            "email" => "momo@momo.com", 
            "password" => "momomomo", 
        );
    }


    public function getObjet()
    {
        $objet = new Auteur();

        foreach ($this->getData() as $key => $value) {
            $objet->{"set" . ucfirst($key)}($value);
        }

        return $objet;
    }

    public function testValide(): void
    {
        $auteur = $this->getObjet();
        
        foreach ($this->getData() as $cle => $value)
            $this->assertTrue($auteur->{"get" . ucfirst($cle)}() === $value);
     
        $this->assertTrue($auteur->getUsername() === $auteur->getEmail()); 
    }

    public function testNonValide(): void
    {
        $auteur = $this->getObjet();
        
        foreach ($this->getData() as $cle => $value)
            $this->assertFalse($auteur->{"get" . ucfirst($cle)}() !== $value);

        $this->assertFalse($auteur->getUsername() !== $auteur->getEmail()); 
    }

    public function testVide(): void
    {
        $auteur = new Auteur();

        foreach ($this->getData() as $cle => $value)
            $this->assertEmpty($auteur->{"get" . ucfirst($cle)}());

        $this->assertEmpty($auteur->getUsername()); 
    }
}
