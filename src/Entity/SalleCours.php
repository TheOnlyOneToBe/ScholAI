<?php

namespace App\Entity;

use App\Repository\SalleCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleCoursRepository::class)]
class SalleCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomSalle = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacite = null;

    #[ORM\ManyToOne(inversedBy: 'salleCours')]
    private ?Campus $campus = null;

    /**
     * @var Collection<int, PlanningCours>
     */
    #[ORM\OneToMany(targetEntity: PlanningCours::class, mappedBy: 'sallecours', orphanRemoval: true)]
    private Collection $planningCours;

    public function __construct()
    {
        $this->planningCours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSalle(): ?string
    {
        return $this->NomSalle;
    }

    public function setNomSalle(string $NomSalle): static
    {
        $this->NomSalle = $NomSalle;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(?int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): static
    {
        $this->campus = $campus;

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
            $planningCour->setSallecours($this);
        }

        return $this;
    }

    public function removePlanningCour(PlanningCours $planningCour): static
    {
        if ($this->planningCours->removeElement($planningCour)) {
            // set the owning side to null (unless already changed)
            if ($planningCour->getSallecours() === $this) {
                $planningCour->setSallecours(null);
            }
        }

        return $this;
    }
}
