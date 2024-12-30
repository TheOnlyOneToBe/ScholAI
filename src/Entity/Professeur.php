<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'professor.email.unique')]
#[UniqueEntity(fields: ['telephone'], message: 'professor.telephone.unique')]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'professor.noms.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'professor.noms.min_length',
        maxMessage: 'professor.noms.max_length'
    )]
    private ?string $noms = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'professor.prenoms.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'professor.prenoms.min_length',
        maxMessage: 'professor.prenoms.max_length'
    )]
    private ?string $prenoms = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'professor.telephone.not_blank')]
    #[Assert\Regex(
        pattern: '/^[0-9+\s-]+$/',
        message: 'professor.telephone.invalid'
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'professor.email.not_blank')]
    #[Assert\Email(message: 'professor.email.invalid')]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'professeurs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'professor.departement.not_blank')]
    private ?Departement $departement = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'professeur', orphanRemoval: true)]
    private Collection $programmes;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): static
    {
        $this->noms = $noms;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->setProfesseur($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getProfesseur() === $this) {
                $programme->setProfesseur(null);
            }
        }

        return $this;
    }
}
