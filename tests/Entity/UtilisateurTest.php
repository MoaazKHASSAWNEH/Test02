<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{

    public function getData() : Array 
    {
        return array(
            "nom" => "KH",
            "prenom" => "momo",
            "photo" => "blabla.png",
            // "dateNaissance" => new \DateTime("25-03-2016"),
            "login" => "momo.momo",
            "password" => "qmlkdjf2kd",
            "adresse" => "23 blabla",
            "email" => "momo@momo.com",
            "civilite" => "homme",
            "statut" => 3,
        );
    }


    public function getUtilisateur()
    {
        $objet = new Utilisateur();
        
        foreach($this->getData() as $key => $value)
        {
            $objet->{"set" . ucfirst($key)}($value);
        }

        // $utilisateur
        //     ->setNom("KH")
        //     ->setPrenom("momo")
        // ;
        
        return $objet;
    }

    public function testValide(): void
    {
        $utilisateur = $this->getUtilisateur();

        foreach($this->getData() as $cle => $value)
            $this->assertTrue($utilisateur->{"get" . ucfirst($cle)}() === $value);

        // $this->assertTrue(true);
        // $this->assertTrue($utilisateur->getNom() === "KH");
        // $this->assertTrue($utilisateur->getPrenom() === "momo");
    }

    public function testNonValide(): void
    {
        $utilisateur = $this->getUtilisateur();
       
        foreach($this->getData() as $cle => $value)
            $this->assertFalse($utilisateur->{"get" . ucfirst($cle)}() !== $value);
        
        // $this->assertTrue(true);
        // $this->assertFalse($utilisateur->getNom() !== "KH");
        // $this->assertFalse($utilisateur->getPrenom() !== "momo");
    }

    public function testVide(): void
    {
        $utilisateur = new Utilisateur();
        
        foreach($this->getData() as $cle => $value)
            $this->assertEmpty($utilisateur->{"get" . ucfirst($cle)}());
        // $this->assertTrue(true);
        // $this->assertEmpty($utilisateur->getNom());
        // $this->assertEmpty($utilisateur->getPrenom());
    }
}
