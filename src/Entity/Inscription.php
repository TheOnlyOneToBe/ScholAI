<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[UniqueEntity(
    fields: ['etudiant', 'filierecycle', 'annee'],
    message: 'inscription.unique_combination'
)]
#[ORM\HasLifecycleCallbacks]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'inscription.etudiant.not_blank')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'inscription.filiere_cycle.not_blank')]
    private ?FiliereCycle $filierecycle = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'inscription.annee.not_blank')]
    private ?Annee $annee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'inscription.date.not_blank')]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\Column]
    private ?bool $statutInscription = null;

    /**
     * @var Collection<int, Reglement>
     */
    #[ORM\OneToMany(targetEntity: Reglement::class, mappedBy: 'inscription', orphanRemoval: true)]
    private Collection $reglements;

    #[Assert\Callback]
    public function validateDateInscription(\Symfony\Component\Validator\Context\ExecutionContextInterface $context): void
    {
        if ($this->dateInscription && $this->annee) {
            if ($this->dateInscription < $this->annee->getYearStart() || $this->dateInscription > $this->annee->getYearEnd()) {
                $context->buildViolation('inscription.date.in_year')
                    ->atPath('dateInscription')
                    ->addViolation();
            }
        }
    }

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
        $this->dateInscription = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFilierecycle(): ?FiliereCycle
    {
        return $this->filierecycle;
    }

    public function setFilierecycle(?FiliereCycle $filierecycle): static
    {
        $this->filierecycle = $filierecycle;

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

    public function isStatutInscription(): ?bool
    {
        return $this->statutInscription;
    }

    public function setStatutInscription(bool $statutInscription): static
    {
        $this->statutInscription = $statutInscription;

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
}
