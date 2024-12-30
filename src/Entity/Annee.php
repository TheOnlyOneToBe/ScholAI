<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AnneeRepository::class)]
#[UniqueEntity(
    fields: ['year_start', 'yearEnd'],
    message: 'annee.dates.overlap'
)]
class Annee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'annee.dates.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\LessThan(
        propertyPath: 'yearEnd',
        message: 'annee.dates.valid_range'
    )]
    private ?\DateTimeInterface $year_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'annee.dates.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThan(
        propertyPath: 'year_start',
        message: 'annee.dates.valid_range'
    )]
    private ?\DateTimeInterface $yearEnd = null;

    #[ORM\Column]
    #[Assert\Type('boolean')]
    private ?bool $yearStatut = false;

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

    #[Assert\Callback]
    public function validateDateRange(\Symfony\Component\Validator\Context\ExecutionContextInterface $context): void
    {
        if ($this->year_start && $this->yearEnd) {
            // Vérifier que l'année scolaire ne chevauche pas une autre année
            // Cette logique devrait être implémentée dans un service
            
            // Vérifier que la durée est d'environ une année
            $interval = $this->year_start->diff($this->yearEnd);
            if ($interval->y > 1 || ($interval->y == 1 && $interval->m > 0) || ($interval->y == 0 && $interval->m < 8)) {
                $context->buildViolation('annee.dates.invalid_duration')
                    ->atPath('yearEnd')
                    ->addViolation();
            }
        }
    }

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->yearStatut = false;
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
