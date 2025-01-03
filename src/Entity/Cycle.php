<?php

namespace App\Entity;

use App\Repository\CycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CycleRepository::class)]
#[UniqueEntity(
    fields: ['nomCycle'],
    message: 'cycle.nom_cycle.unique'
)]
class Cycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'cycle.nom_cycle.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'cycle.nom_cycle.min_length',
        maxMessage: 'cycle.nom_cycle.max_length'
    )]
    private ?string $nomCycle = null;

    /**
     * @var Collection<int, FiliereCycle>
     */
    #[ORM\OneToMany(targetEntity: FiliereCycle::class, mappedBy: 'Cycle', orphanRemoval: true)]
    private Collection $filiereCycles;

    public function __construct()
    {
        $this->filiereCycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCycle(): ?string
    {
        return $this->nomCycle;
    }

    public function setNomCycle(string $nomCycle): static
    {
        $this->nomCycle = $nomCycle;

        return $this;
    }

    /**
     * @return Collection<int, FiliereCycle>
     */
    public function getFiliereCycles(): Collection
    {
        return $this->filiereCycles;
    }

    public function addFiliereCycle(FiliereCycle $filiereCycle): static
    {
        if (!$this->filiereCycles->contains($filiereCycle)) {
            $this->filiereCycles->add($filiereCycle);
            $filiereCycle->setCycle($this);
        }

        return $this;
    }

    public function removeFiliereCycle(FiliereCycle $filiereCycle): static
    {
        if ($this->filiereCycles->removeElement($filiereCycle)) {
            // set the owning side to null (unless already changed)
            if ($filiereCycle->getCycle() === $this) {
                $filiereCycle->setCycle(null);
            }
        }

        return $this;
    }
}
