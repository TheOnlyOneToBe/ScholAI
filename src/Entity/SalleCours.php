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

    #[ORM\Column(length: 150)]
    private ?string $nomSalle = null;

    #[ORM\ManyToOne(inversedBy: 'salleCours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $Campus = null;

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
        return $this->Campus;
    }

    public function setCampus(?Campus $Campus): static
    {
        $this->Campus = $Campus;

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


}
