<?php

namespace App\Tests\Entity;

use App\Entity\Commentaire;
use PHPUnit\Framework\TestCase;

class CommentaireTest extends TestCase
{
    public function testSomething(): void
    {
        $commentaire = new Commentaire();
        $commentaire
            ->setAuteur("momo")
            ->setContenu("momokh")
        ;
        $this->assertTrue($commentaire->getAuteur() === "momo");
        $this->assertTrue($commentaire->getContenu() === "momokh");
    }

    public function testNonValide(): void
    {
        $commentaire = new Commentaire();
        $commentaire
            ->setAuteur("momo")
            ->setContenu("momokh")
        ;
        $this->assertFalse($commentaire->getAuteur() !== "momo");
        $this->assertFalse($commentaire->getContenu() !== "momokh");
    }
}
