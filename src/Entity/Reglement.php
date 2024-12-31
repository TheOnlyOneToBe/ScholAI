<?php

namespace App\Entity;

use App\Repository\ReglementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ReglementRepository::class)]
class Reglement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'reglement.inscription.not_null')]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'reglement.libelle_reglement.not_null')]
    private ?PayementReason $libelle_reglement = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'reglement.payementmethod.not_null')]
    private ?PayementMethod $payementmethod = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'reglement.montant_reglee.not_null')]
    #[Assert\Positive(message: 'reglement.montant_reglee.must_be_positive')]
    #[Assert\LessThanOrEqual(
        value: 10000000,
        message: 'reglement.montant_reglee.max_amount'
    )]
    private ?float $montant_reglee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'reglement.datereglement.not_null')]
    #[Assert\LessThanOrEqual('today', message: 'reglement.datereglement.must_be_past_or_today')]
    #[Assert\Expression(
        "this.getDatereglement() >= this.getInscription().getAnnee().getYearStart()",
        message: 'reglement.datereglement.must_be_within_academic_year'
    )]
    private ?\DateTimeInterface $datereglement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getLibelleReglement(): ?PayementReason
    {
        return $this->libelle_reglement;
    }

    public function setLibelleReglement(?PayementReason $libelle_reglement): static
    {
        $this->libelle_reglement = $libelle_reglement;

        return $this;
    }

    public function getPayementmethod(): ?PayementMethod
    {
        return $this->payementmethod;
    }

    public function setPayementmethod(?PayementMethod $payementmethod): static
    {
        $this->payementmethod = $payementmethod;

        return $this;
    }

    public function getMontantReglee(): ?float
    {
        return $this->montant_reglee;
    }

    public function setMontantReglee(float $montant_reglee): static
    {
        $this->montant_reglee = $montant_reglee;

        return $this;
    }

    public function getDatereglement(): ?\DateTimeInterface
    {
        return $this->datereglement;
    }

    public function setDatereglement(\DateTimeInterface $datereglement): static
    {
        $this->datereglement = $datereglement;

        return $this;
    }

    #[Assert\Callback]
    public function validatePayment(ExecutionContextInterface $context): void
    {
        if (!$this->inscription || !$this->montant_reglee || !$this->libelle_reglement) {
            return;
        }

        // Get FiliereCycle fees
        $filiereCycle = $this->inscription->getFiliereCycle();
        $fraisInscription = $filiereCycle->getFraisInscription();
        $montantPension = $filiereCycle->getMontantPension();
        
        // Calculate total amount due based on payment reason
        $totalDue = 0;
        if ($this->libelle_reglement->getRaison() === 'pension') {
            // For pension, total due is inscription + pension
            $totalDue = $fraisInscription + $montantPension;
            
            // Check for scholarship
            foreach ($this->inscription->getEtudiant()->getBourses() as $bourse) {
                if ($bourse->getAnnee() === $this->inscription->getAnnee()) {
                    // Apply scholarship reduction to the total amount
                    $reduction = ($bourse->getRemise() / 100) * $totalDue;
                    $totalDue -= $reduction;
                    break; // Assume only one scholarship per academic year
                }
            }
        } else {
            $totalDue = $this->libelle_reglement->getMontantAttendu();
        }

        // Calculate total amount already paid for this type of payment
        $totalPaid = 0;
        foreach ($this->inscription->getReglements() as $reglement) {
            if ($reglement !== $this && $reglement->getLibelleReglement() === $this->libelle_reglement) {
                $totalPaid += $reglement->getMontantReglee();
            }
        }
        $totalPaid += $this->montant_reglee;

        // Validate payment doesn't exceed due amount
        if ($totalPaid > $totalDue) {
            $context->buildViolation('reglement.montant_reglee.exceeds_expected')
                ->setParameter('{{ total }}', $totalPaid)
                ->setParameter('{{ expected }}', $totalDue)
                ->atPath('montant_reglee')
                ->addViolation();
        }
    }
}
