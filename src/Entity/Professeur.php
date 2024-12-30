<?php

namespace App\Entity;

use App\Enum\Genre;
use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
#[UniqueEntity(
    fields: ['email'],
    message: 'professeur.email.unique'
)]
#[UniqueEntity(
    fields: ['cni'],
    message: 'professeur.cni.unique'
)]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'professeur.nom.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'professeur.nom.min_length',
        maxMessage: 'professeur.nom.max_length'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'professeur.prenom.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'professeur.prenom.min_length',
        maxMessage: 'professeur.prenom.max_length'
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'professeur.email.not_blank')]
    #[Assert\Email(message: 'professeur.email.invalid')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'professeur.numero_telephone.not_blank')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9]{9,15}$/',
        message: 'professeur.numero_telephone.invalid_format'
    )]
    private ?string $numeroTelephone = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'professeur.cni.not_blank')]
    #[Assert\Regex(
        pattern: '/^[A-Z0-9]+$/',
        message: 'professeur.cni.invalid_format'
    )]
    private ?string $cni = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'professeur.date_naissance.not_null')]
    #[Assert\LessThan(
        'today',
        message: 'professeur.date_naissance.must_be_past'
    )]
    #[Assert\Expression(
        "this.getDateNaissance() <= new \DateTime('-18 years')",
        message: 'professeur.date_naissance.must_be_adult'
    )]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'professeur.nationalite.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'professeur.nationalite.min_length',
        maxMessage: 'professeur.nationalite.max_length'
    )]
    private ?string $nationalite = null;

    #[ORM\Column(length: 10, enumType: Genre::class)]
    #[Assert\NotNull(message: 'professeur.sexe.not_null')]
    private ?Genre $sexe = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'professeur.adresse.not_blank')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'professeur.adresse.min_length',
        maxMessage: 'professeur.adresse.max_length'
    )]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Image(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png'],
        maxSizeMessage: 'professeur.photo_profil.max_size',
        mimeTypesMessage: 'professeur.photo_profil.mime_types'
    )]
    private ?string $photoProfil = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: 'professeur.date_creation.not_null')]
    #[Assert\LessThanOrEqual(
        'now',
        message: 'professeur.date_creation.must_be_past_or_present'
    )]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModification = null;

    #[ORM\ManyToOne(inversedBy: 'professeurs')]
    private ?Departement $departement = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'professeur')]
    private Collection $utilisateurs;

    /**
     * @var Collection<int, UE>
     */
    #[ORM\OneToMany(targetEntity: UE::class, mappedBy: 'profeseur', orphanRemoval: true)]
    private Collection $uEs;

    /**
     * @var Collection<int, ChefDepartement>
     */
    #[ORM\OneToMany(targetEntity: ChefDepartement::class, mappedBy: 'professeur', orphanRemoval: true)]
    private Collection $chefDepartements;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->uEs = new ArrayCollection();
        $this->chefDepartements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): static
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): static
    {
        $this->cni = $cni;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getSexe(): ?Genre
    {
        return $this->sexe;
    }

    public function setSexe(Genre $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil(?string $photoProfil): static
    {
        $this->photoProfil = $photoProfil;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModification(): \DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): static
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setProfesseur($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getProfesseur() === $this) {
                $utilisateur->setProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UE>
     */
    public function getUEs(): Collection
    {
        return $this->uEs;
    }

    public function addUE(UE $uE): static
    {
        if (!$this->uEs->contains($uE)) {
            $this->uEs->add($uE);
            $uE->setProfeseur($this);
        }

        return $this;
    }

    public function removeUE(UE $uE): static
    {
        if ($this->uEs->removeElement($uE)) {
            // set the owning side to null (unless already changed)
            if ($uE->getProfeseur() === $this) {
                $uE->setProfeseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChefDepartement>
     */
    public function getChefDepartements(): Collection
    {
        return $this->chefDepartements;
    }

    public function addChefDepartement(ChefDepartement $chefDepartement): static
    {
        if (!$this->chefDepartements->contains($chefDepartement)) {
            $this->chefDepartements->add($chefDepartement);
            $chefDepartement->setProfesseur($this);
        }

        return $this;
    }

    public function removeChefDepartement(ChefDepartement $chefDepartement): static
    {
        if ($this->chefDepartements->removeElement($chefDepartement)) {
            // set the owning side to null (unless already changed)
            if ($chefDepartement->getProfesseur() === $this) {
                $chefDepartement->setProfesseur(null);
            }
        }

        return $this;
    }
}
