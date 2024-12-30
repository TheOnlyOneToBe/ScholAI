<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
#[UniqueEntity(fields: ['uniteenseignement'], message: 'matiere.uniteenseignement.unique')]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'matiere.uniteenseignement.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 200,
        minMessage: 'matiere.uniteenseignement.min_length',
        maxMessage: 'matiere.uniteenseignement.max_length'
    )]
    private ?string $uniteenseignement = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'matiere', orphanRemoval: true)]
    private Collection $programmes;



    public function __construct()
    {
        $this->programmes = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniteenseignement(): ?string
    {
        return $this->uniteenseignement;
    }

    public function setUniteenseignement(string $uniteenseignement): static
    {
        $this->uniteenseignement = $uniteenseignement;

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
            $programme->setMatiere($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getMatiere() === $this) {
                $programme->setMatiere(null);
            }
        }

        return $this;
    }

}
