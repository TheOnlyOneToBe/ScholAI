<?php

namespace App\Entity;

use App\Enum\StatutInscription;
use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[UniqueEntity(
    fields: ['etudiant', 'filiereCycle', 'semestre'],
    message: 'inscription.etudiant_filiere_semestre.unique'
)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'inscription.etudiant.not_null')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'inscription.filiere_cycle.not_null')]
    private ?FiliereCycle $filiereCycle = null;

    #[ORM\Column(length: 50, enumType: StatutInscription::class)]
    #[Assert\NotNull(message: 'inscription.statut.not_null')]
    private ?StatutInscription $statut = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'inscription.is_suspended.not_null')]
    private ?bool $isSuspended = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'inscription.semestre.not_null')]
    private ?Semestre $semestre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'inscription.date_inscription.not_null')]
    #[Assert\LessThanOrEqual(
        'today',
        message: 'inscription.date_inscription.must_be_past_or_today'
    )]
    private ?\DateTimeInterface $dateInscription = null;

    /**
     * @var Collection<int, Reglement>
     */
    #[ORM\OneToMany(targetEntity: Reglement::class, mappedBy: 'inscription', orphanRemoval: true)]
    private Collection $reglements;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeAcademique $annee = null;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
    }

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

    public function getFiliereCycle(): ?FiliereCycle
    {
        return $this->filiereCycle;
    }

    public function setFiliereCycle(?FiliereCycle $filiereCycle): static
    {
        $this->filiereCycle = $filiereCycle;

        return $this;
    }

    public function getStatut(): ?StatutInscription
    {
        return $this->statut;
    }

    public function setStatut(StatutInscription $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function isSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    public function setSuspended(bool $isSuspended): static
    {
        $this->isSuspended = $isSuspended;

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

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @return Collection<int, Reglement>
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(Reglement $reglement): static
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements->add($reglement);
            $reglement->setInscription($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): static
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getInscription() === $this) {
                $reglement->setInscription(null);
            }
        }

        return $this;
    }

    public function getAnnee(): ?AnneeAcademique
    {
        return $this->annee;
    }

    public function setAnnee(?AnneeAcademique $annee): static
    {
        $this->annee = $annee;

        return $this;
    }
}
