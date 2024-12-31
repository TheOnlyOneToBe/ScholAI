<?php

namespace App\Entity;

use App\Repository\BourseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BourseRepository::class)]
class Bourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'bourse.montant.not_null')]
    #[Assert\GreaterThan(
        value: 0,
        message: 'bourse.montant.must_be_positive'
    )]
    private ?float $montant = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'bourse.remise.must_be_positive_or_zero'
    )]
    #[Assert\LessThanOrEqual(
        value: 100,
        message: 'bourse.remise.must_be_less_than_100'
    )]
    private ?float $remise = null;

    #[ORM\ManyToOne(inversedBy: 'bourses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'bourse.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'bourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeAcademique $annee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(?float $remise): static
    {
        $this->remise = $remise;

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

    public function getAnnee(): ?AnneeAcademique
    {
        return $this->annee;
    }

    public function setAnnee(?AnneeAcademique $annee): static
    {
        $this->annee = $annee;

        return $this;
    }
}
