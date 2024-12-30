<?php

namespace App\Entity;

use App\Repository\SalleCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SalleCoursRepository::class)]
#[UniqueEntity(fields: ['numero'], message: 'salle_cours.numero.unique')]
class SalleCours
{
    public const TYPES = [
        'Amphi' => 'Amphithéâtre',
        'TD' => 'Salle de TD',
        'TP' => 'Salle de TP',
        'Labo' => 'Laboratoire'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'salle_cours.numero.not_blank')]
    private ?string $numero = null;

    #[ORM\Column(length: 150)]
    private ?string $nomSalle = null;

    #[ORM\ManyToOne(inversedBy: 'salles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'salle_cours.capacite.not_blank')]
    #[Assert\Range(
        min: 10,
        max: 500,
        notInRangeMessage: 'salle_cours.capacite.not_in_range'
    )]
    private ?int $capacite = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'salle_cours.type.not_blank')]
    #[Assert\Choice(
        choices: self::TYPES,
        message: 'salle_cours.type.invalid'
    )]
    private ?string $type = null;

    /**
     * @var Collection<int, EmploiTemps>
     */
    #[ORM\OneToMany(targetEntity: EmploiTemps::class, mappedBy: 'salle', orphanRemoval: true)]
    private Collection $emploiTemps;

    public function __construct()
    {
        $this->emploiTemps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNomSalle(): ?string
    {
        return $this->nomSalle;
    }

    public function setNomSalle(string $nomSalle): static
    {
        $this->nomSalle = $nomSalle;

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

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, EmploiTemps>
     */
    public function getEmploiTemps(): Collection
    {
        return $this->emploiTemps;
    }

    public function addEmploiTemp(EmploiTemps $emploiTemp): static
    {
        if (!$this->emploiTemps->contains($emploiTemp)) {
            $this->emploiTemps->add($emploiTemp);
            $emploiTemp->setSalle($this);
        }

        return $this;
    }

    public function removeEmploiTemp(EmploiTemps $emploiTemp): static
    {
        if ($this->emploiTemps->removeElement($emploiTemp)) {
            // set the owning side to null (unless already changed)
            if ($emploiTemp->getSalle() === $this) {
                $emploiTemp->setSalle(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->numero;
    }
}
