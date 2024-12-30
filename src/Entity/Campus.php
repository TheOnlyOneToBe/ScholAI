<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
#[UniqueEntity(fields: ['nomCampus'], message: 'campus.nomCampus.unique')]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank(message: 'campus.nomCampus.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'campus.nomCampus.min_length',
        maxMessage: 'campus.nomCampus.max_length'
    )]
    private ?string $nomCampus = null;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'campus.adresse.not_blank')]
    private ?string $adresse = null;

    /**
     * @var Collection<int, SalleCours>
     */
    #[ORM\OneToMany(targetEntity: SalleCours::class, mappedBy: 'campus', orphanRemoval: true)]
    private Collection $salles;

    public function __construct()
    {
        $this->salles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCampus(): ?string
    {
        return $this->nomCampus;
    }

    public function setNomCampus(string $nomCampus): static
    {
        $this->nomCampus = $nomCampus;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, SalleCours>
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(SalleCours $salle): static
    {
        if (!$this->salles->contains($salle)) {
            $this->salles->add($salle);
            $salle->setCampus($this);
        }

        return $this;
    }

    public function removeSalle(SalleCours $salle): static
    {
        if ($this->salles->removeElement($salle)) {
            // set the owning side to null (unless already changed)
            if ($salle->getCampus() === $this) {
                $salle->setCampus(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomCampus;
    }
}
