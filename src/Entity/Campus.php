<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100,unique:true)]
    private ?string $nomCampus = null;

    #[ORM\Column(length: 200)]
    private ?string $adresse = null;


    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'campuses')]
    private ?self $campus = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'campus')]
    private Collection $campuses;

    /**
     * @var Collection<int, SalleCours>
     */
    #[ORM\OneToMany(targetEntity: SalleCours::class, mappedBy: 'Campus', orphanRemoval: true)]
    private Collection $salleCours;

    public function __construct()
    {
        $this->campuses = new ArrayCollection();
        $this->salleCours = new ArrayCollection();
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

    public function getCampus(): ?self
    {
        return $this->campus;
    }

    public function setCampus(?self $campus): static
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCampuses(): Collection
    {
        return $this->campuses;
    }

    public function addCampus(self $campus): static
    {
        if (!$this->campuses->contains($campus)) {
            $this->campuses->add($campus);
            $campus->setCampus($this);
        }

        return $this;
    }

    public function removeCampus(self $campus): static
    {
        if ($this->campuses->removeElement($campus)) {
            // set the owning side to null (unless already changed)
            if ($campus->getCampus() === $this) {
                $campus->setCampus(null);
            }
        }

        return $this;
    }

    public function addSalleCour(SalleCours $salleCour): static
    {
        if (!$this->salleCours->contains($salleCour)) {
            $this->salleCours->add($salleCour);
            $salleCour->setCampus($this);
        }

        return $this;
    }

    public function removeSalleCour(SalleCours $salleCour): static
    {
        if ($this->salleCours->removeElement($salleCour)) {
            // set the owning side to null (unless already changed)
            if ($salleCour->getCampus() === $this) {
                $salleCour->setCampus(null);
            }
        }

        return $this;
    }
}
