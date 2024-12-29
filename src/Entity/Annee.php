<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnneeRepository::class)]
class Annee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $year_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $yearEnd = null;

    #[ORM\Column]
    private ?bool $yearStatut = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'annee', orphanRemoval: true)]
    private Collection $inscriptions;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'annee', orphanRemoval: true)]
    private Collection $programmes;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYearStart(): ?\DateTimeInterface
    {
        return $this->year_start;
    }

    public function setYearStart(\DateTimeInterface $year_start): static
    {
        $this->year_start = $year_start;

        return $this;
    }

    public function getYearEnd(): ?\DateTimeInterface
    {
        return $this->yearEnd;
    }

    public function setYearEnd(\DateTimeInterface $yearEnd): static
    {
        $this->yearEnd = $yearEnd;

        return $this;
    }

    public function isYearStatut(): ?bool
    {
        return $this->yearStatut;
    }

    public function setYearStatut(bool $yearStatut): static
    {
        $this->yearStatut = $yearStatut;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setAnnee($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getAnnee() === $this) {
                $inscription->setAnnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->setAnnee($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getAnnee() === $this) {
                $programme->setAnnee(null);
            }
        }

        return $this;
    }
}
