<?php

namespace App\Entity;

use App\Enum\Genre;
use App\Enum\TypeTuteur;
use App\Repository\TuteurEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TuteurEtudiantRepository::class)]
class TuteurEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 10,enumType: Genre::class)]
    private ?string $sexe = null;

    #[ORM\Column(length: 24)]
    private ?string $numTelephone = null;
    #[ORM\Column(length: 30,enumType: TypeTuteur::class)]
    private ?string $typeTuteur = null;
    #[ORM\ManyToOne(inversedBy: 'tuteurEtudiants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(string $numTelephone): static
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeTuteur(): ?string
    {
        return $this->typeTuteur;
    }

    /**
     * @param string|null $typeTuteur
     */
    public function setTypeTuteur(?string $typeTuteur): void
    {
        $this->typeTuteur = $typeTuteur;
    }
}
