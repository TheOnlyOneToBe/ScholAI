<?php

namespace App\Entity;

use App\Enum\Genre;
use App\Enum\TypeTuteur;
use App\Repository\TuteurEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TuteurEtudiantRepository::class)]
#[UniqueEntity(
    fields: ['numTelephone'],
    message: 'tuteur_etudiant.num_telephone.unique'
)]
class TuteurEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'tuteur_etudiant.nom.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'tuteur_etudiant.nom.min_length',
        maxMessage: 'tuteur_etudiant.nom.max_length'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'tuteur_etudiant.prenom.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'tuteur_etudiant.prenom.min_length',
        maxMessage: 'tuteur_etudiant.prenom.max_length'
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 12, enumType: Genre::class)]
    #[Assert\NotNull(message: 'tuteur_etudiant.sexe.not_null')]
    private ?Genre $sexe = null;

    #[ORM\Column(length: 24)]
    #[Assert\NotBlank(message: 'tuteur_etudiant.num_telephone.not_blank')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9]{9,15}$/',
        message: 'tuteur_etudiant.num_telephone.invalid_format'
    )]
    private ?string $numTelephone = null;

    #[ORM\Column(length: 30, enumType: TypeTuteur::class)]
    #[Assert\NotNull(message: 'tuteur_etudiant.type_tuteur.not_null')]
    private ?TypeTuteur $typeTuteur = null;

    #[ORM\ManyToOne(inversedBy: 'tuteurEtudiants')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'tuteur_etudiant.etudiant.not_null')]
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

    public function getSexe(): ?Genre
    {
        return $this->sexe;
    }

    public function setSexe(Genre $sexe): static
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
     * @return TypeTuteur|null
     */
    public function getTypeTuteur(): ?TypeTuteur
    {
        return $this->typeTuteur;
    }

    /**
     * @param TypeTuteur|null $typeTuteur
     */
    public function setTypeTuteur(TypeTuteur $typeTuteur): static
    {
        $this->typeTuteur = $typeTuteur;
        return $this;
    }
}
