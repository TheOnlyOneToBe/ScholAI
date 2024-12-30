<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
#[UniqueEntity(
    fields: ['nomFiliere'],
    message: 'filiere.nom_filiere.unique'
)]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'filiere.nom_filiere.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 150,
        minMessage: 'filiere.nom_filiere.min_length',
        maxMessage: 'filiere.nom_filiere.max_length'
    )]
    private ?string $nomFiliere = null;

    /**
     * @var Collection<int, FiliereCycle>
     */
    #[ORM\OneToMany(targetEntity: FiliereCycle::class, mappedBy: 'filiere', orphanRemoval: true)]
    private Collection $filiereCycles;

    public function __construct()
    {
        $this->filiereCycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFiliere(): ?string
    {
        return $this->nomFiliere;
    }

    public function setNomFiliere(string $nomFiliere): static
    {
        $this->nomFiliere = $nomFiliere;

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
