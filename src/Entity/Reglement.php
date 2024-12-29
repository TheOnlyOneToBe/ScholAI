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

    #[ORM\Column]
    private ?int $ontantReglement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateReglement = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PayementMethod $PayementMethod = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    private ?PayementReason $payementReason = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOntantReglement(): ?int
    {
        return $this->ontantReglement;
    }

    public function setOntantReglement(int $ontantReglement): static
    {
        $this->ontantReglement = $ontantReglement;

        return $this;
    }

    public function getDateReglement(): ?\DateTimeInterface
    {
        return $this->dateReglement;
    }

    public function setDateReglement(\DateTimeInterface $dateReglement): static
    {
        $this->dateReglement = $dateReglement;

        return $this;
    }

    public function getPayementMethod(): ?PayementMethod
    {
        return $this->PayementMethod;
    }

    public function setPayementMethod(?PayementMethod $PayementMethod): static
    {
        $this->PayementMethod = $PayementMethod;

        return $this;
    }

    public function getPayementReason(): ?PayementReason
    {
        return $this->payementReason;
    }

    public function setPayementReason(?PayementReason $payementReason): static
    {
        $this->payementReason = $payementReason;

        return $this;
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
}
