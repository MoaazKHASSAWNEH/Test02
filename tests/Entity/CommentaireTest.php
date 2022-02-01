<?php

namespace App\Tests\Entity;

use App\Entity\Commentaire;
use Egulias\EmailValidator\Parser\Comment;
use PHPUnit\Framework\TestCase;

class CommentaireTest extends TestCase
{
    public function getData(): array
    {
        return array(
            "auteur" => "Momo KH",
            "email" => "momo@momo.com",
            "contenu" => "C'est le contenu",
        );
    }


    public function getObjet()
    {
        $objet = new Commentaire();

        foreach ($this->getData() as $key => $value) {
            $objet->{"set" . ucfirst($key)}($value);
        }

        return $objet;
    }

    public function testValide(): void
    {
        $commentaire = $this->getObjet();
        $date = new \DateTime("25-01-2020"); 
        $commentaire->setDate($date); 
        foreach ($this->getData() as $cle => $value)
            $this->assertTrue($commentaire->{"get" . ucfirst($cle)}() === $value);
        
        $this->assertTrue($commentaire->getDate() === $date); 
    }

    public function testNonValide(): void
    {
        $commentaire = $this->getObjet();
        $date = new \DateTime("25-01-2020"); 
        $commentaire->setDate($date); 
        foreach ($this->getData() as $cle => $value)
            $this->assertFalse($commentaire->{"get" . ucfirst($cle)}() !== $value);
        
        $this->assertFalse($commentaire->getDate() !== $date); 
    }

    public function testVide(): void
    {
        $commentaire = new Commentaire();

        foreach ($this->getData() as $cle => $value)
            $this->assertEmpty($commentaire->{"get" . ucfirst($cle)}());

        $this->assertEmpty($commentaire->getDate()); 
    }
}
