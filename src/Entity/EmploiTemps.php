<?php

namespace App\Entity;

use App\Repository\EmploiTempsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EmploiTempsRepository::class)]
#[UniqueEntity(
    fields: ['salle', 'jour', 'heure_debut'],
    message: 'emploi_temps.overlap',
    errorPath: 'heure_debut'
)]
#[ORM\HasLifecycleCallbacks]
class EmploiTemps
{
    public const JOURS = [
        'Lundi' => 'Lundi',
        'Mardi' => 'Mardi',
        'Mercredi' => 'Mercredi',
        'Jeudi' => 'Jeudi',
        'Vendredi' => 'Vendredi',
        'Samedi' => 'Samedi'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'emploi_temps.jour.not_blank')]
    #[Assert\Choice(
        choices: self::JOURS,
        message: 'emploi_temps.jour.valid_choice'
    )]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'emploi_temps.heure_debut.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'emploi_temps.heure_fin.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\Expression(
        "this.getHeureFin() > this.getHeureDebut()",
        message: 'emploi_temps.heure_fin.after_start'
    )]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\ManyToOne(inversedBy: 'emploiTemps')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'emploi_temps.salle.not_blank')]
    private ?SalleCours $salle = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'emploi_temps.programme.not_blank')]
    private ?Programme $programme = null;

    #[Assert\Callback]
    public function validateTimeSlot(\Symfony\Component\Validator\Context\ExecutionContextInterface $context): void
    {
        if ($this->heure_debut && $this->heure_fin && $this->programme && $this->programme->getProfesseur()) {
            // Cette validation devrait être déplacée dans un service
            // Vérifier si le professeur n'a pas déjà un cours à ce moment
            $professeur = $this->programme->getProfesseur();
            
            // Si le professeur a déjà un cours à ce moment
            $context->buildViolation('emploi_temps.professor_busy')
                ->atPath('heure_debut')
                ->addViolation();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(?string $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): static
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): static
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getSalle(): ?SalleCours
    {
        return $this->salle;
    }

    public function setSalle(?SalleCours $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): static
    {
        $this->programme = $programme;

        return $this;
    }
}
