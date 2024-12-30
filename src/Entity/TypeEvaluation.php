<?php

namespace App\Entity;

use App\Repository\TypeEvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypeEvaluationRepository::class)]
#[UniqueEntity(
    fields: ['titre'],
    message: 'type_evaluation.titre.unique'
)]
class TypeEvaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'type_evaluation.titre.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'type_evaluation.titre.min_length',
        maxMessage: 'type_evaluation.titre.max_length'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z\s]+$/',
        message: 'type_evaluation.titre.invalid_format'
    )]
    private ?string $titre = null;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'type', orphanRemoval: true)]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setType($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getType() === $this) {
                $evaluation->setType(null);
            }
        }

        return $this;
    }
}
