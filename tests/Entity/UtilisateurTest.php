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
        
        return $objet;
    }

    public function testValide(): void
    {
        $utilisateur = $this->getUtilisateur();
        $date = new \DateTime("25-03-2016 00:00:00");
        $utilisateur->setDateNaissance($date);
        foreach($this->getData() as $cle => $value)
            $this->assertTrue($utilisateur->{"get" . ucfirst($cle)}() === $value);

        $this->assertTrue($utilisateur->getUsername() === $utilisateur->getEmail());
        $this->assertTrue($utilisateur->getDateNaissance() === $date);
        
    }

    public function testNonValide(): void
    {
        $utilisateur = $this->getUtilisateur();
        $date = new \DateTime("25-03-2016 00:00:00");
        $utilisateur->setDateNaissance($date);
        foreach($this->getData() as $cle => $value)
            $this->assertFalse($utilisateur->{"get" . ucfirst($cle)}() !== $value);
        

        $this->assertFalse($utilisateur->getUsername() !== $utilisateur->getEmail());
        $this->assertFalse($utilisateur->getDateNaissance() !== $date);
    }

    public function testVide(): void
    {
        $utilisateur = new Utilisateur();
        
        foreach($this->getData() as $cle => $value)
            $this->assertEmpty($utilisateur->{"get" . ucfirst($cle)}());
        
        $this->assertEmpty($utilisateur->getUsername());
        $this->assertEmpty($utilisateur->getDateNaissance());
    }
}
