<?php

namespace App\Entity;

use App\Repository\SemestreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SemestreRepository::class)]
#[UniqueEntity(
    fields: ['nomsemestre', 'datedebut'],
    message: 'semestre.nomsemestre.unique'
)]
#[ORM\HasLifecycleCallbacks]
class Semestre
{
    public const NUMEROS = [1, 2];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'semestre.nomsemestre.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'semestre.nomsemestre.min_length',
        maxMessage: 'semestre.nomsemestre.max_length'
    )]
    private ?string $nomsemestre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'semestre.datedebut.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $datedebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'semestre.datefin.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\Expression(
        "this.getDatefin() > this.getDatedebut()",
        message: 'semestre.dates.valid_range'
    )]
    private ?\DateTimeInterface $datefin = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'semestre', orphanRemoval: true)]
    private Collection $programmes;

    #[Assert\Callback]
    public function validateDateRange(\Symfony\Component\Validator\Context\ExecutionContextInterface $context): void
    {
        if ($this->datedebut && $this->datefin) {
            // Vérifier que les dates sont valides
            if ($this->datedebut >= $this->datefin) {
                $context->buildViolation('semestre.dates.outside_year')
                    ->atPath('datedebut')
                    ->addViolation();
            }
        }
    }

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomsemestre(): ?string
    {
        return $this->nomsemestre;
    }

    public function setNomsemestre(string $nomsemestre): static
    {
        $this->nomsemestre = $nomsemestre;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): static
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): static
    {
        $this->datefin = $datefin;

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
            $programme->setSemestre($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getSemestre() === $this) {
                $programme->setSemestre(null);
            }
        }

        return $this;
    }
}
