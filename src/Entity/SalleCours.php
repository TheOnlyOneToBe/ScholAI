<?php

namespace App\Entity;

use App\Repository\SalleCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SalleCoursRepository::class)]
#[UniqueEntity(
    fields: ['NomSalle', 'campus'],
    message: 'salle_cours.nom_salle_campus.unique'
)]
class SalleCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'salle_cours.nom_salle.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'salle_cours.nom_salle.min_length',
        maxMessage: 'salle_cours.nom_salle.max_length'
    )]
    private ?string $NomSalle = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(
        value: 0,
        message: 'salle_cours.capacite.must_be_positive'
    )]
    #[Assert\LessThan(
        value: 1000,
        message: 'salle_cours.capacite.too_large'
    )]
    private ?int $capacite = null;

    #[ORM\ManyToOne(inversedBy: 'salleCours')]
    #[Assert\NotNull(message: 'salle_cours.campus.not_null')]
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
