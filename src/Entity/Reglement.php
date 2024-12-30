<?php

namespace App\Entity;

use App\Repository\ReglementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReglementRepository::class)]
class Reglement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PayementReason $libelle_reglement = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PayementMethod $payementmethod = null;

    #[ORM\Column]
    private ?float $montant_reglee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datereglement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getLibelleReglement(): ?PayementReason
    {
        return $this->libelle_reglement;
    }

    public function setLibelleReglement(?PayementReason $libelle_reglement): static
    {
        $this->libelle_reglement = $libelle_reglement;

        return $this;
    }

    public function getPayementmethod(): ?PayementMethod
    {
        return $this->payementmethod;
    }

    public function setPayementmethod(?PayementMethod $payementmethod): static
    {
        $this->payementmethod = $payementmethod;

        return $this;
    }

    public function getMontantReglee(): ?float
    {
        return $this->montant_reglee;
    }

    public function setMontantReglee(float $montant_reglee): static
    {
        $this->montant_reglee = $montant_reglee;

        return $this;
    }

    public function getDatereglement(): ?\DateTimeInterface
    {
        return $this->datereglement;
    }

    public function setDatereglement(\DateTimeInterface $datereglement): static
    {
        $this->datereglement = $datereglement;

        return $this;
    }
}
