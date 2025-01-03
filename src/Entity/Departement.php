<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[UniqueEntity(
    fields: ['nomDepartement'],
    message: 'departement.nom_departement.unique'
)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'departement.nom_departement.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'departement.nom_departement.min_length',
        maxMessage: 'departement.nom_departement.max_length'
    )]
    private ?string $nomDepartement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: 'departement.date_creation.not_null')]
    #[Assert\LessThanOrEqual(
        value: 'now',
        message: 'departement.date_creation.must_be_past_or_today'
    )]
    private ?\DateTimeInterface $dateCreation = null;

    /**
     * @var Collection<int, Professeur>
     */
    #[ORM\OneToMany(targetEntity: Professeur::class, mappedBy: 'departement')]
    private Collection $professeurs;

    /**
     * @var Collection<int, ChefDepartement>
     */
    #[ORM\OneToMany(targetEntity: ChefDepartement::class, mappedBy: 'departement', orphanRemoval: true)]
    private Collection $chefDepartements;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->chefDepartements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nomDepartement;
    }

    public function setNomDepartement(string $nomDepartement): static
    {
        $this->nomDepartement = $nomDepartement;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): static
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
            $professeur->setDepartement($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): static
    {
        if ($this->professeurs->removeElement($professeur)) {
            // set the owning side to null (unless already changed)
            if ($professeur->getDepartement() === $this) {
                $professeur->setDepartement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChefDepartement>
     */
    public function getChefDepartements(): Collection
    {
        return $this->chefDepartements;
    }

    public function addChefDepartement(ChefDepartement $chefDepartement): static
    {
        if (!$this->chefDepartements->contains($chefDepartement)) {
            $this->chefDepartements->add($chefDepartement);
            $chefDepartement->setDepartement($this);
        }

        return $this;
    }

    public function removeChefDepartement(ChefDepartement $chefDepartement): static
    {
        if ($this->chefDepartements->removeElement($chefDepartement)) {
            // set the owning side to null (unless already changed)
            if ($chefDepartement->getDepartement() === $this) {
                $chefDepartement->setDepartement(null);
            }
        }

        return $this;
    }
}
