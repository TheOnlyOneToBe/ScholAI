<?php

namespace App\Entity;

use App\Repository\ChefDepartementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ChefDepartementRepository::class)]
#[UniqueEntity(
    fields: ['professeur', 'departement'],
    message: 'chef_departement.professeur_departement.unique'
)]
class ChefDepartement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'chefDepartements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'chef_departement.professeur.not_null')]
    private ?Professeur $professeur = null;

    #[ORM\ManyToOne(inversedBy: 'chefDepartements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'chef_departement.departement.not_null')]
    private ?Departement $departement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'chef_departement.date_debut_mandat.not_null')]
    #[Assert\LessThanOrEqual(
        'today',
        message: 'chef_departement.date_debut_mandat.must_be_past_or_today'
    )]
    private ?\DateTimeInterface $dateDebutMandat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getDateDebutMandat(): ?\DateTimeInterface
    {
        return $this->dateDebutMandat;
    }

    public function setDateDebutMandat(\DateTimeInterface $dateDebutMandat): static
    {
        $this->dateDebutMandat = $dateDebutMandat;

        return $this;
    }
}
