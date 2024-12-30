<?php

namespace App\Entity;

use App\Repository\PayementreasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementreasonRepository::class)]
class Payementreason
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Raison = null;

    /**
     * @var Collection<int, Reglement>
     */
    #[ORM\OneToMany(targetEntity: Reglement::class, mappedBy: 'libelle_reglement')]
    private Collection $reglements;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaison(): ?string
    {
        return $this->Raison;
    }

    public function setRaison(string $Raison): static
    {
        $this->Raison = $Raison;

        return $this;
    }

    /**
     * @return Collection<int, Reglement>
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(Reglement $reglement): static
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements->add($reglement);
            $reglement->setLibelleReglement($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): static
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getLibelleReglement() === $this) {
                $reglement->setLibelleReglement(null);
            }
        }

        return $this;
    }
}
