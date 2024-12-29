<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professeur $professeur = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FiliereCycle $FiliereCycle = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annee $annee = null;

    #[ORM\Column]
    private ?int $heurealloue = null;

    /**
     * @var Collection<int, EmploiTemps>
     */
    #[ORM\OneToMany(targetEntity: EmploiTemps::class, mappedBy: 'programme', orphanRemoval: true)]
    private Collection $emploiTemps;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    private ?Semestre $semestre = null;

    public function __construct()
    {
        $this->emploiTemps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getFiliereCycle(): ?FiliereCycle
    {
        return $this->FiliereCycle;
    }

    public function setFiliereCycle(?FiliereCycle $FiliereCycle): static
    {
        $this->FiliereCycle = $FiliereCycle;

        return $this;
    }

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getHeurealloue(): ?int
    {
        return $this->heurealloue;
    }

    public function setHeurealloue(int $heurealloue): static
    {
        $this->heurealloue = $heurealloue;

        return $this;
    }

    /**
     * @return Collection<int, EmploiTemps>
     */
    public function getEmploiTemps(): Collection
    {
        return $this->emploiTemps;
    }

    public function addEmploiTemp(EmploiTemps $emploiTemp): static
    {
        if (!$this->emploiTemps->contains($emploiTemp)) {
            $this->emploiTemps->add($emploiTemp);
            $emploiTemp->setProgramme($this);
        }

        return $this;
    }

    public function removeEmploiTemp(EmploiTemps $emploiTemp): static
    {
        if ($this->emploiTemps->removeElement($emploiTemp)) {
            // set the owning side to null (unless already changed)
            if ($emploiTemp->getProgramme() === $this) {
                $emploiTemp->setProgramme(null);
            }
        }

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }
}
