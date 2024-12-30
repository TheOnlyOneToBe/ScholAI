<?php

namespace App\Entity;

use App\Repository\PayementmethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementmethodRepository::class)]
class Payementmethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $PayementName = null;

    /**
     * @var Collection<int, Reglement>
     */
    #[ORM\OneToMany(targetEntity: Reglement::class, mappedBy: 'payementmethod', orphanRemoval: true)]
    private Collection $reglements;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayementName(): ?string
    {
        return $this->PayementName;
    }

    public function setPayementName(string $PayementName): static
    {
        $this->PayementName = $PayementName;

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
            $reglement->setPayementmethod($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): static
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getPayementmethod() === $this) {
                $reglement->setPayementmethod(null);
            }
        }

        return $this;
    }
}
