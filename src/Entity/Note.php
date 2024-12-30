<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[UniqueEntity(
    fields: ['etudiant', 'evaluation'],
    message: 'note.etudiant_evaluation.unique'
)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'note.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'note.evaluation.not_null')]
    private ?Evaluation $evaluation = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'note.note_value.not_null')]
    #[Assert\Range(
        min: 0,
        max: 20,
        notInRangeMessage: 'note.note_value.not_in_range'
    )]
    private ?float $noteValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getNoteValue(): ?float
    {
        return $this->noteValue;
    }

    public function setNoteValue(float $noteValue): static
    {
        $this->noteValue = $noteValue;

        return $this;
    }
}
