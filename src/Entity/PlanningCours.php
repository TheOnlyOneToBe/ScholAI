<?php

namespace App\Entity;

use App\Repository\PlanningCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PlanningCoursRepository::class)]
#[UniqueEntity(
    fields: ['UE', 'sallecours', 'jour', 'heureDebut'],
    message: 'planning_cours.unique_cours'
)]
class PlanningCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'planningCours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'planning_cours.ue.not_null')]
    private ?UE $UE = null;

    #[ORM\ManyToOne(inversedBy: 'planningCours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'planning_cours.salle_cours.not_null')]
    private ?SalleCours $sallecours = null;

    #[ORM\Column(length: 16)]
    #[Assert\NotBlank(message: 'planning_cours.jour.not_blank')]
    #[Assert\Choice(
        choices: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        message: 'planning_cours.jour.invalid_choice'
    )]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message: 'planning_cours.heure_debut.not_null')]
    #[Assert\Expression(
        "this.getHeureDebut() < this.getHeureFin()",
        message: 'planning_cours.heure_debut.must_be_before_fin'
    )]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message: 'planning_cours.heure_fin.not_null')]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'planning_cours.type_cours.not_blank')]
    #[Assert\Choice(
        choices: ['CM', 'TD', 'TP'],
        message: 'planning_cours.type_cours.invalid_choice'
    )]
    private ?string $typeCours = null;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'PlanningCours', orphanRemoval: true)]
    private Collection $presences;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
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

    public function getSallecours(): ?SalleCours
    {
        return $this->sallecours;
    }

    public function setSallecours(?SalleCours $sallecours): static
    {
        $this->sallecours = $sallecours;

        return $this;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getTypeCours(): ?string
    {
        return $this->typeCours;
    }

    public function setTypeCours(string $typeCours): static
    {
        $this->typeCours = $typeCours;

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
            $presence->setPlanningCours($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getPlanningCours() === $this) {
                $presence->setPlanningCours(null);
            }
        }

        return $this;
    }
}
