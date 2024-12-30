<?php

namespace App\Entity;

use App\Repository\FiliereCycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FiliereCycleRepository::class)]
#[UniqueEntity(
    fields: ['filiere', 'Cycle'],
    message: 'filiere_cycle.filiere_cycle.unique'
)]
class FiliereCycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'filiere_cycle.description.not_blank')]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'filiere_cycle.description.min_length',
        maxMessage: 'filiere_cycle.description.max_length'
    )]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'filiereCycles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'filiere_cycle.filiere.not_null')]
    private ?Filiere $filiere = null;

    #[ORM\ManyToOne(inversedBy: 'filiereCycles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'filiere_cycle.cycle.not_null')]
    private ?Cycle $Cycle = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'filiere_cycle.frais_inscription.not_null')]
    #[Assert\GreaterThan(
        value: 0,
        message: 'filiere_cycle.frais_inscription.must_be_positive'
    )]
    private ?float $fraisInscription = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'filiere_cycle.montant_pension.not_null')]
    #[Assert\GreaterThan(
        value: 0,
        message: 'filiere_cycle.montant_pension.must_be_positive'
    )]
    private ?float $montantPension = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'filiereCycle', orphanRemoval: true)]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getCycle(): ?Cycle
    {
        return $this->Cycle;
    }

    public function setCycle(?Cycle $Cycle): static
    {
        $this->Cycle = $Cycle;

        return $this;
    }

    public function getFraisInscription(): ?float
    {
        return $this->fraisInscription;
    }

    public function setFraisInscription(float $fraisInscription): static
    {
        $this->fraisInscription = $fraisInscription;

        return $this;
    }

    public function getMontantPension(): ?float
    {
        return $this->montantPension;
    }

    public function setMontantPension(float $montantPension): static
    {
        $this->montantPension = $montantPension;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setFiliereCycle($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getFiliereCycle() === $this) {
                $inscription->setFiliereCycle(null);
            }
        }

        return $this;
    }
}
