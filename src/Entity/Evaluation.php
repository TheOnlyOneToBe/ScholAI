<?php

namespace App\Entity;

use App\Enum\StatutEvaluation;
use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'evaluation.ue.not_null')]
    private ?UE $UE = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'evaluation.semestre.not_null')]
    private ?Semestre $semestre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'evaluation.date_debut.not_null')]
    #[Assert\GreaterThanOrEqual(
        'today',
        message: 'evaluation.date_debut.must_be_future'
    )]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'evaluation.temps_evaluation.not_null')]
    #[Assert\Positive(message: 'evaluation.temps_evaluation.must_be_positive')]
    #[Assert\LessThanOrEqual(
        value: 240,
        message: 'evaluation.temps_evaluation.max_duration'
    )]
    private ?int $tempsEvaluation = null;

    #[ORM\Column(length: 50, enumType: StatutEvaluation::class)]
    #[Assert\NotNull(message: 'evaluation.statut.not_null')]
    private ?string $statut = null;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'evaluation')]
    private Collection $notes;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'evaluation.type.not_null')]
    private ?TypeEvaluation $type = null;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUE(): ?UE
    {
        return $this->UE;
    }

    public function setUE(?UE $UE): static
    {
        $this->UE = $UE;

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getTempsEvaluation(): ?int
    {
        return $this->tempsEvaluation;
    }

    public function setTempsEvaluation(int $tempsEvaluation): static
    {
        $this->tempsEvaluation = $tempsEvaluation;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setEvaluation($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEvaluation() === $this) {
                $note->setEvaluation(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypeEvaluation
    {
        return $this->type;
    }

    public function setType(?TypeEvaluation $type): static
    {
        $this->type = $type;

        return $this;
    }
}
