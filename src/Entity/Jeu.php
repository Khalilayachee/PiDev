<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]
class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_jeu = null;

    #[ORM\Column(length: 255)]
    private ?string $description_jeu = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date_de_sortie = null;

    

    #[ORM\Column(nullable: true)]
    private ?string $images = null;

    #[ORM\ManyToOne(inversedBy: 'jeus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJeu(): ?string
    {
        return $this->nom_jeu;
    }

    public function setNomJeu(string $nom_jeu): static
    {
        $this->nom_jeu = $nom_jeu;

        return $this;
    }

    public function getDescriptionJeu(): ?string
    {
        return $this->description_jeu;
    }

    public function setDescriptionJeu(string $description_jeu): static
    {
        $this->description_jeu = $description_jeu;

        return $this;
    }

    public function getDateDeSortie(): ?\DateTimeInterface
    {
        return $this->date_de_sortie;
    }

    public function setDateDeSortie(\DateTimeInterface $date_de_sortie): self
    {
        $this->date_de_sortie = $date_de_sortie;

        return $this;
    }

  
    

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    
}
