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
    fields: ['numSemestre', 'anneeacademique'],
    message: 'semestre.num_semestre_annee.unique'
)]
class Semestre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'semestre.num_semestre.not_blank')]
    #[Assert\Regex(
        pattern: '/^S[1-6]$/',
        message: 'semestre.num_semestre.invalid_format'
    )]
    private ?string $numSemestre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'semestre.date_debut.not_null')]
    #[Assert\Expression(
        "this.getDateDebut() < this.getDateFin()",
        message: 'semestre.date_debut.must_be_before_fin'
    )]
    #[Assert\Expression(
        "this.getDateDebut() >= this.getAnneeacademique().getYearStart() and this.getDateDebut() <= this.getAnneeacademique().getYearEnd()",
        message: 'semestre.date_debut.must_be_in_academic_year'
    )]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'semestre.date_fin.not_null')]
    #[Assert\Expression(
        "this.getDateFin() >= this.getDateDebut()",
        message: 'semestre.date_fin.must_be_after_debut'
    )]
    #[Assert\Expression(
        "this.getDateFin() >= this.getAnneeacademique().getYearStart() and this.getDateFin() <= this.getAnneeacademique().getYearEnd()",
        message: 'semestre.date_fin.must_be_in_academic_year'
    )]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'semestres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'semestre.annee_academique.not_null')]
    private ?AnneeAcademique $anneeacademique = null;


    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'semestre', orphanRemoval: true)]
    private Collection $inscriptions;

    /**
     * @var Collection<int, UE>
     */
    #[ORM\OneToMany(targetEntity: UE::class, mappedBy: 'semestre', orphanRemoval: true)]
    private Collection $uEs;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'smestre', orphanRemoval: true)]
    private Collection $evaluations;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->uEs = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSemestre(): ?string
    {
        return $this->numSemestre;
    }

    public function setNumSemestre(string $numSemestre): static
    {
        $this->numSemestre = $numSemestre;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getAnneeacademique(): ?AnneeAcademique
    {
        return $this->anneeacademique;
    }

    public function setAnneeacademique(?AnneeAcademique $anneeacademique): static
    {
        $this->anneeacademique = $anneeacademique;

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
            $inscription->setSemestre($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSemestre() === $this) {
                $inscription->setSemestre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UE>
     */
    public function getUEs(): Collection
    {
        return $this->uEs;
    }

    public function addUE(UE $uE): static
    {
        if (!$this->uEs->contains($uE)) {
            $this->uEs->add($uE);
            $uE->setSemestre($this);
        }

        return $this;
    }

    public function removeUE(UE $uE): static
    {
        if ($this->uEs->removeElement($uE)) {
            // set the owning side to null (unless already changed)
            if ($uE->getSemestre() === $this) {
                $uE->setSemestre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setSmestre($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getSmestre() === $this) {
                $evaluation->setSmestre(null);
            }
        }

        return $this;
    }
}
