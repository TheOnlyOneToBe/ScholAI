<?php

namespace App\Entity;

use App\Enum\StatutPresence;
use App\Repository\PresenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
#[UniqueEntity(
    fields: ['etudiant', 'UE', 'PlanningCours'],
    message: 'presence.etudiant_ue_planning.unique'
)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'presence.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'presence.ue.not_null')]
    private ?UE $UE = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'presence.planning_cours.not_null')]
    private ?PlanningCours $PlanningCours = null;

    #[ORM\Column(length: 50, enumType: StatutPresence::class)]
    #[Assert\NotNull(message: 'presence.statut.not_null')]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
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

    public function getPlanningCours(): ?PlanningCours
    {
        return $this->PlanningCours;
    }

    public function setPlanningCours(?PlanningCours $PlanningCours): static
    {
        $this->PlanningCours = $PlanningCours;

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
}
