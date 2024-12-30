<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
#[UniqueEntity(fields: ['libellefiliere'], message: 'filiere.libelle.unique')]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'filiere.libelle.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'filiere.libelle.min_length',
        maxMessage: 'filiere.libelle.max_length'
    )]
    private ?string $libellefiliere = null;

    /**
     * @var Collection<int, FiliereCycle>
     */
    #[ORM\OneToMany(targetEntity: FiliereCycle::class, mappedBy: 'filiere')]
    private Collection $filiereCycles;

    public function __construct()
    {
        $this->filiereCycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellefiliere(): ?string
    {
        return $this->libellefiliere;
    }

    public function setLibellefiliere(string $libellefiliere): static
    {
        $this->libellefiliere = $libellefiliere;

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
            $filiereCycle->setFiliere($this);
        }

        return $this;
    }

    public function removeFiliereCycle(FiliereCycle $filiereCycle): static
    {
        if ($this->filiereCycles->removeElement($filiereCycle)) {
            // set the owning side to null (unless already changed)
            if ($filiereCycle->getFiliere() === $this) {
                $filiereCycle->setFiliere(null);
            }
        }

        return $this;
    }
}
