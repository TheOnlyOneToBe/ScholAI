<?php

namespace App\Entity;

use App\Repository\UERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UERepository::class)]
class UE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'uEs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'uEs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professeur $profeseur = null;

    #[ORM\Column]
    private ?int $volumeHoraire = null;

    #[ORM\ManyToOne(inversedBy: 'uEs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Semestre $semestre = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'UE', orphanRemoval: true)]
    private Collection $evaluations;

    /**
     * @var Collection<int, PlanningCours>
     */
    #[ORM\OneToMany(targetEntity: PlanningCours::class, mappedBy: 'UE')]
    private Collection $planningCours;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'UE', orphanRemoval: true)]
    private Collection $presences;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
        $this->planningCours = new ArrayCollection();
        $this->presences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?Cours
    {
        return $this->matiere;
    }

    public function setMatiere(?Cours $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getProfeseur(): ?Professeur
    {
        return $this->profeseur;
    }

    public function setProfeseur(?Professeur $profeseur): static
    {
        $this->profeseur = $profeseur;

        return $this;
    }

    public function getVolumeHoraire(): ?int
    {
        return $this->volumeHoraire;
    }

    public function setVolumeHoraire(int $volumeHoraire): static
    {
        $this->volumeHoraire = $volumeHoraire;

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
            $evaluation->setUE($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getUE() === $this) {
                $evaluation->setUE(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlanningCours>
     */
    public function getPlanningCours(): Collection
    {
        return $this->planningCours;
    }

    public function addPlanningCour(PlanningCours $planningCour): static
    {
        if (!$this->planningCours->contains($planningCour)) {
            $this->planningCours->add($planningCour);
            $planningCour->setUE($this);
        }

        return $this;
    }

    public function removePlanningCour(PlanningCours $planningCour): static
    {
        if ($this->planningCours->removeElement($planningCour)) {
            // set the owning side to null (unless already changed)
            if ($planningCour->getUE() === $this) {
                $planningCour->setUE(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): static
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setUE($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getUE() === $this) {
                $presence->setUE(null);
            }
        }

        return $this;
    }
}
