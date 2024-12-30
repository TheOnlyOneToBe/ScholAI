<?php

namespace App\Entity;

use App\Repository\AntecedentAcademiqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AntecedentAcademiqueRepository::class)]
class AntecedentAcademique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etablissement = null;

    #[ORM\Column(length: 255)]
    private ?string $diplome = null;

    #[ORM\Column(length: 255)]
    private ?string $matriculeDiplome = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $anneeObtention = null;

    #[ORM\ManyToOne(inversedBy: 'antecedentAcademiques')]
    #[ORM\JoinColumn(nullable: false)]
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
