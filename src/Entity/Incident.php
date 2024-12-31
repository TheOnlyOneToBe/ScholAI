<?php

namespace App\Entity;

use App\Enum\GraviteIncident;
use App\Repository\IncidentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IncidentRepository::class)]
class Incident
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'incident.titre.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'incident.titre.min_length',
        maxMessage: 'incident.titre.max_length'
    )]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'incident.description.not_blank')]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'incident.description.min_length',
        maxMessage: 'incident.description.max_length'
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: 'incident.date_incident.not_null')]
    #[Assert\LessThanOrEqual(
        'today',
        message: 'incident.date_incident.must_be_past_or_today'
    )]
    private ?\DateTimeInterface $dateIncident = null;

    #[ORM\Column(length: 255, enumType: GraviteIncident::class)]
    #[Assert\NotNull(message: 'incident.gravite.not_null')]
    private ?GraviteIncident $gravite = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'incidents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'incident.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDateIncident(): ?\DateTimeInterface
    {
        return $this->dateIncident;
    }

    public function setDateIncident(\DateTimeInterface $dateIncident): static
    {
        $this->dateIncident = $dateIncident;
        return $this;
    }

    public function getGravite(): ?GraviteIncident
    {
        return $this->gravite;
    }

    public function setGravite(GraviteIncident $gravite): static
    {
        $this->gravite = $gravite;
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

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;
        return $this;
    }
}
