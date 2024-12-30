<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[UniqueEntity(fields: ['studentEmail'], message: 'student.email.unique')]
#[UniqueEntity(fields: ['telephone'], message: 'student.telephone.unique')]
#[UniqueEntity(fields: ['matriculeStudent'], message: 'student.matricule.unique')]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'student.noms.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'student.noms.min_length',
        maxMessage: 'student.noms.max_length'
    )]
    private ?string $noms = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'student.prenoms.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'student.prenoms.min_length',
        maxMessage: 'student.prenoms.max_length'
    )]
    private ?string $prenoms = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(
        min: 15,
        max: 50,
        notInRangeMessage: 'student.age.not_in_range',
    )]
    private ?int $age = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message: 'student.telephone.not_blank')]
    #[Assert\Regex(
        pattern: '/^[0-9+\s-]+$/',
        message: 'student.telephone.invalid'
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresseStudent = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 1)]
    private ?string $sexeEtudiant = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'student.matricule.not_blank')]
    private ?string $matriculeStudent = null;

    #[ORM\Column(length: 150)]
    private ?string $studentFather = null;

    #[ORM\Column(length: 150)]
    private ?string $studentMother = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $father_number = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $mother_number = null;

    #[ORM\Column(length: 70)]
    #[Assert\NotBlank(message: 'student.email.not_blank')]
    #[Assert\Email(message: 'student.email.invalid')]
    private ?string $studentEmail = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\NotBlank(message: 'student.date_naissance.not_blank')]
    #[Assert\Type('\DateTimeInterface')]
    #[Assert\LessThanOrEqual('today', message: 'student.date_naissance.valid_date')]
    private ?\DateTimeInterface $dateNaissance = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): static
    {
        $this->noms = $noms;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresseStudent(): ?string
    {
        return $this->adresseStudent;
    }

    public function setAdresseStudent(?string $adresseStudent): static
    {
        $this->adresseStudent = $adresseStudent;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSexeEtudiant(): ?string
    {
        return $this->sexeEtudiant;
    }

    public function setSexeEtudiant(string $sexeEtudiant): static
    {
        $this->sexeEtudiant = $sexeEtudiant;

        return $this;
    }

    public function getMatriculeStudent(): ?string
    {
        return $this->matriculeStudent;
    }

    public function setMatriculeStudent(?string $matriculeStudent): static
    {
        $this->matriculeStudent = $matriculeStudent;

        return $this;
    }

    public function getStudentFather(): ?string
    {
        return $this->studentFather;
    }

    public function setStudentFather(string $studentFather): static
    {
        $this->studentFather = $studentFather;

        return $this;
    }

    public function getStudentMother(): ?string
    {
        return $this->studentMother;
    }

    public function setStudentMother(string $studentMother): static
    {
        $this->studentMother = $studentMother;

        return $this;
    }

    public function getFatherNumber(): ?string
    {
        return $this->father_number;
    }

    public function setFatherNumber(?string $father_number): static
    {
        $this->father_number = $father_number;

        return $this;
    }

    public function getMotherNumber(): ?string
    {
        return $this->mother_number;
    }

    public function setMotherNumber(?string $mother_number): static
    {
        $this->mother_number = $mother_number;

        return $this;
    }

    public function getStudentEmail(): ?string
    {
        return $this->studentEmail;
    }

    public function setStudentEmail(string $studentEmail): static
    {
        $this->studentEmail = $studentEmail;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

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
            $inscription->setEtudiant($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEtudiant() === $this) {
                $inscription->setEtudiant(null);
            }
        }

        return $this;
    }
}
