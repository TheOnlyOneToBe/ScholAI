<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
#[UniqueEntity(
    fields: ['nomCampus'],
    message: 'campus.nom_campus.unique'
)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'campus.nom_campus.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 150,
        minMessage: 'campus.nom_campus.min_length',
        maxMessage: 'campus.nom_campus.max_length'
    )]
    private ?string $nomCampus = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'campus.adresse_campus.min_length',
        maxMessage: 'campus.adresse_campus.max_length'
    )]
    private ?string $adresseCampus = null;

    /**
     * @var Collection<int, SalleCours>
     */
    #[ORM\OneToMany(targetEntity: SalleCours::class, mappedBy: 'campus')]
    private Collection $salleCours;

    public function __construct()
    {
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

    public function getAdresseCampus(): ?string
    {
        return $this->adresseCampus;
    }

    public function setAdresseCampus(?string $adresseCampus): static
    {
        $this->adresseCampus = $adresseCampus;

        return $this;
    }

    /**
     * @return Collection<int, SalleCours>
     */
    public function getSalleCours(): Collection
    {
        return $this->salleCours;
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
