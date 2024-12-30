<?php

namespace App\Entity;

use App\Repository\CycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CycleRepository::class)]
#[UniqueEntity(fields: ['libelle'], message: 'cycle.libelle.unique')]
class Cycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'cycle.libelle.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'cycle.libelle.min_length',
        maxMessage: 'cycle.libelle.max_length'
    )]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'cycle.duree.not_blank')]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'cycle.duree.not_in_range'
    )]
    private ?int $duree = null;

    /**
     * @var Collection<int, FiliereCycle>
     */
    #[ORM\OneToMany(targetEntity: FiliereCycle::class, mappedBy: 'cycle', orphanRemoval: true)]
    private Collection $filiereCycles;

    public function __construct()
    {
        $this->filiereCycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;
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

    public function __toString(): string
    {
        return $this->libelle;
    }
}
