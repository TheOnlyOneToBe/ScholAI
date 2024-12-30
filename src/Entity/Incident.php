<?php

namespace App\Entity;

use App\Enum\GraviteIncident;
use App\Enum\TypeAvertissement;
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
    private ?string $gravite = null;

    #[ORM\Column(length: 255, enumType: TypeAvertissement::class)]
    #[Assert\NotNull(message: 'incident.type_incident.not_null')]
    private ?string $typeIncident = null;

    #[ORM\ManyToOne(inversedBy: 'incidents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'incident.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGravite(): ?string
    {
        return $this->gravite;
    }

    public function setGravite(string $gravite): static
    {
        $this->gravite = $gravite;

        return $this;
    }

    public function getTypeIncident(): ?string
    {
        return $this->typeIncident;
    }

    public function setTypeIncident(string $typeIncident): static
    {
        $this->typeIncident = $typeIncident;

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
