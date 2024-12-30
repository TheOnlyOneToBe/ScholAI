<?php

namespace App\Entity;

use App\Repository\AntecedentAcademiqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AntecedentAcademiqueRepository::class)]
class AntecedentAcademique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'antecedent_academique.etablissement.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'antecedent_academique.etablissement.min_length',
        maxMessage: 'antecedent_academique.etablissement.max_length'
    )]
    private ?string $etablissement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'antecedent_academique.diplome.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'antecedent_academique.diplome.min_length',
        maxMessage: 'antecedent_academique.diplome.max_length'
    )]
    private ?string $diplome = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'antecedent_academique.matricule_diplome.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'antecedent_academique.matricule_diplome.min_length',
        maxMessage: 'antecedent_academique.matricule_diplome.max_length'
    )]
    private ?string $matriculeDiplome = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'antecedent_academique.annee_obtention.not_null')]
    #[Assert\LessThanOrEqual('today', message: 'antecedent_academique.annee_obtention.must_be_past')]
    private ?\DateTimeInterface $anneeObtention = null;

    #[ORM\ManyToOne(inversedBy: 'antecedentAcademiques')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'antecedent_academique.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(string $etablissement): static
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getMatriculeDiplome(): ?string
    {
        return $this->matriculeDiplome;
    }

    public function setMatriculeDiplome(string $matriculeDiplome): static
    {
        $this->matriculeDiplome = $matriculeDiplome;

        return $this;
    }

    public function getAnneeObtention(): ?\DateTimeInterface
    {
        return $this->anneeObtention;
    }

    public function setAnneeObtention(\DateTimeInterface $anneeObtention): static
    {
        $this->anneeObtention = $anneeObtention;

        return $this;
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
}
