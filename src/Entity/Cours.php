<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[UniqueEntity(
    fields: ['nomCours'],
    message: 'cours.nom_cours.unique'
)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'cours.nom_cours.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'cours.nom_cours.min_length',
        maxMessage: 'cours.nom_cours.max_length'
    )]
    private ?string $nomCours = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'cours.descriptif.min_length',
        maxMessage: 'cours.descriptif.max_length'
    )]
    private ?string $descriptif = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'cours.type_cours.not_blank')]
    #[Assert\Choice(
        choices: ['CM', 'TD', 'TP'],
        message: 'cours.type_cours.invalid_choice'
    )]
    private ?string $typeCours = null;

    /**
     * @var Collection<int, UE>
     */
    #[ORM\OneToMany(targetEntity: UE::class, mappedBy: 'matiere', orphanRemoval: true)]
    private Collection $uEs;

    public function __construct()
    {
        $this->uEs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nomCours;
    }

    public function setNomCours(string $nomCours): static
    {
        $this->nomCours = $nomCours;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): static
    {
        $this->descriptif = $descriptif;

        return $this;
    }
    

    public function getTypeCours(): ?string
    {
        return $this->typeCours;
    }

    public function setTypeCours(string $typeCours): static
    {
        $this->typeCours = $typeCours;

        return $this;
    }

    /**
     * @return Collection<int, UE>
     */
    public function getUEs(): Collection
    {
        return $this->uEs;
    }

    public function addUE(UE $uE): static
    {
        if (!$this->uEs->contains($uE)) {
            $this->uEs->add($uE);
            $uE->setMatiere($this);
        }

        return $this;
    }

    public function removeUE(UE $uE): static
    {
        if ($this->uEs->removeElement($uE)) {
            // set the owning side to null (unless already changed)
            if ($uE->getMatiere() === $this) {
                $uE->setMatiere(null);
            }
        }

        return $this;
    }
}
