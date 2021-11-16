<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @UniqueEntity(
 *      fields = "titre",
 *      message = "Cette catégorie existe déjà"
 * )
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 25,
     *      minMessage = "Le Titre doit contenir au minimum 4 caractères",
     *      maxMessage = "Le titre ne peut contenir que 25 caractères au maximum"
     * )
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=750)
     * @Assert\Length(
     *      min = 4, 
     *      max = 140,
     *      minMessage = "Le résumé doit contenir plus de 4 caractères",
     *      maxMessage = "Le résumé ne peut contenir que 140 caractères"     
     * )
     */
    private $resume;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }
}
