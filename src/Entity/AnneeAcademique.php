<?php

namespace App\Entity;

use App\Repository\AnneeAcademiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: AnneeAcademiqueRepository::class)]
#[UniqueEntity(
    fields: ['YearStart', 'YearEnd'],
    message: 'annee_academique.period.unique'
)]
class AnneeAcademique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'annee_academique.year_start.not_null')]
    #[Assert\LessThanOrEqual(
        'today + 1 year',
        message: 'annee_academique.year_start.not_too_far_future'
    )]
    private ?\DateTimeInterface $YearStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'annee_academique.year_end.not_null')]
    #[Assert\GreaterThan(
        propertyPath: 'YearStart',
        message: 'annee_academique.year_end.must_be_after_start'
    )]
    private ?\DateTimeInterface $YearEnd = null;

    #[ORM\Column]
    private ?bool $isCurrent = null;

    /**
     * @var Collection<int, Semestre>
     */
    #[ORM\OneToMany(targetEntity: Semestre::class, mappedBy: 'anneeacademique')]
    private Collection $semestres;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'annee', orphanRemoval: true)]
    private Collection $inscriptions;

    /**
     * @var Collection<int, Bourse>
     */
    #[ORM\OneToMany(targetEntity: Bourse::class, mappedBy: 'annee', orphanRemoval: true)]
    private Collection $bourses;

    public function __construct()
    {
        $this->semestres = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->bourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYearStart(): ?\DateTimeInterface
    {
        return $this->YearStart;
    }

    public function setYearStart(\DateTimeInterface $YearStart): static
    {
        $this->YearStart = $YearStart;

        return $this;
    }

    public function getYearEnd(): ?\DateTimeInterface
    {
        return $this->YearEnd;
    }

    public function setYearEnd(\DateTimeInterface $YearEnd): static
    {
        $this->YearEnd = $YearEnd;

        return $this;
    }

    public function isCurrent(): ?bool
    {
        return $this->isCurrent;
    }

    public function setCurrent(bool $isCurrent): static
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    /**
     * @return Collection<int, Semestre>
     */
    public function getSemestres(): Collection
    {
        return $this->semestres;
    }

    public function addSemestre(Semestre $semestre): static
    {
        if (!$this->semestres->contains($semestre)) {
            $this->semestres->add($semestre);
            $semestre->setAnneeacademique($this);
        }

        return $this;
    }

    public function removeSemestre(Semestre $semestre): static
    {
        if ($this->semestres->removeElement($semestre)) {
            // set the owning side to null (unless already changed)
            if ($semestre->getAnneeacademique() === $this) {
                $semestre->setAnneeacademique(null);
            }
        }

        return $this;
    }

    #[Assert\Callback]
    public function validateYearRange(ExecutionContextInterface $context): void
    {
        if ($this->YearStart && $this->YearEnd) {
            $diff = $this->YearStart->diff($this->YearEnd);
            if ($diff->y > 1) {
                $context->buildViolation('annee_academique.year_range.too_long')
                    ->atPath('YearEnd')
                    ->addViolation();
            }
        }
    }

    #[Assert\Callback]
    public function validateYearEndNotTooFar(ExecutionContextInterface $context): void
    {
        if ($this->YearStart && $this->YearEnd) {
            $maxEndDate = (clone $this->YearStart)->modify('+1 year');
            if ($this->YearEnd > $maxEndDate) {
                $context->buildViolation('annee_academique.year_end.max_one_year')
                    ->atPath('YearEnd')
                    ->addViolation();
            }
        }
    }

    /*#[Assert\Callback]
    public function validateCurrentYear(ExecutionContextInterface $context): void
    {
        /*if ($this->isCurrent) {
            $repository = $context->getRoot()->getRepository(AnneeAcademique::class);
            $existingCurrent = $repository->findOneBy(['isCurrent' => true]);
            
            if ($existingCurrent && $existingCurrent !== $this) {
                $context->buildViolation('annee_academique.is_current.only_one')
                    ->atPath('isCurrent')
                    ->addViolation();
            }
        }
    }*/

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
     * @return Collection<int, Bourse>
     */
    public function getBourses(): Collection
    {
        return $this->bourses;
    }

    public function addBourse(Bourse $bourse): static
    {
        if (!$this->bourses->contains($bourse)) {
            $this->bourses->add($bourse);
            $bourse->setAnnee($this);
        }

        return $this;
    }

    public function removeBourse(Bourse $bourse): static
    {
        if ($this->bourses->removeElement($bourse)) {
            // set the owning side to null (unless already changed)
            if ($bourse->getAnnee() === $this) {
                $bourse->setAnnee(null);
            }
        }

        return $this;
    }
}
