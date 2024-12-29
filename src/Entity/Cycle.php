<?php

namespace App\Entity;

use App\Repository\CycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CycleRepository::class)]
class Cycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, FiliereCycle>
     */
    #[ORM\OneToMany(targetEntity: FiliereCycle::class, mappedBy: 'cycle')]
    private Collection $filiereCycles;

    public function __construct()
    {
        $this->filiereCycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
