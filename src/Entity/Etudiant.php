<?php

namespace App\Entity;

use App\Enum\Genre;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 12, enumType: Genre::class)]
    #[Assert\NotNull(message: 'etudiant.sexe.not_null')]
    private ?Genre $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'etudiant.date_naissance.not_null')]
    #[Assert\LessThan('today', message: 'etudiant.date_naissance.less_than_today')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'etudiant.adresse.not_blank')]
    #[Assert\Length(min: 5, max: 255, 
        minMessage: 'etudiant.adresse.min_length',
        maxMessage: 'etudiant.adresse.max_length'
    )]
    private ?string $adresse = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'etudiant.registration_allowed.not_null')]
    private bool $isRegistrationAllowed = true;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'etudiant.nom.not_blank')]
    #[Assert\Length(min: 2, max: 255,
        minMessage: 'etudiant.nom.min_length',
        maxMessage: 'etudiant.nom.max_length'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'etudiant.prenom.not_blank')]
    #[Assert\Length(min: 2, max: 255,
        minMessage: 'etudiant.prenom.min_length',
        maxMessage: 'etudiant.prenom.max_length'
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'etudiant.email.not_blank')]
    #[Assert\Email(message: 'etudiant.email.invalid')]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'etudiant.telephone.not_blank')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9]{9,15}$/',
        message: 'etudiant.telephone.invalid'
    )]
    private ?string $numTelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuNaissance = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $studentPhoto = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[A-Z]{2}[0-9]{6}$/',
        message: 'etudiant.cni.invalid'
    )]
    private ?string $cni = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModification = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'Etudiant')]
    private Collection $utilisateurs;

    /**
     * @var Collection<int, TuteurEtudiant>
     */
    #[ORM\OneToMany(targetEntity: TuteurEtudiant::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $tuteurEtudiants;

    /**
     * @var Collection<int, AntecedentAcademique>
     */
    #[ORM\OneToMany(targetEntity: AntecedentAcademique::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $antecedentAcademiques;

    /**
     * @var Collection<int, Bourse>
     */
    #[ORM\OneToMany(targetEntity: Bourse::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $bourses;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $inscriptions;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $notes;

    /**
     * @var Collection<int, Incident>
     */
    #[ORM\OneToMany(targetEntity: Incident::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $incidents;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $presences;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->tuteurEtudiants = new ArrayCollection();
        $this->antecedentAcademiques = new ArrayCollection();
        $this->bourses = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->incidents = new ArrayCollection();
        $this->presences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexe(): ?Genre
    {
        return $this->sexe;
    }

    public function setSexe(?Genre $sexe): static
    {
        $this->sexe = $sexe;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isRegistrationAllowed(): ?bool
    {
        return $this->isRegistrationAllowed;
    }

    public function setRegistrationAllowed(bool $isRegistrationAllowed): static
    {
        $this->isRegistrationAllowed = $isRegistrationAllowed;

        return $this;
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

    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(string $numTelephone): static
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): static
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getStudentPhoto(): ?string
    {
        return $this->studentPhoto;
    }

    public function setStudentPhoto(?string $studentPhoto): static
    {
        $this->studentPhoto = $studentPhoto;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(?string $cni): static
    {
        $this->cni = $cni;

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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): static
    {
        $this->dateModification = $dateModification;

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
            $utilisateur->setEtudiant($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getEtudiant() === $this) {
                $utilisateur->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TuteurEtudiant>
     */
    public function getTuteurEtudiants(): Collection
    {
        return $this->tuteurEtudiants;
    }

    public function addTuteurEtudiant(TuteurEtudiant $tuteurEtudiant): static
    {
        if (!$this->tuteurEtudiants->contains($tuteurEtudiant)) {
            $this->tuteurEtudiants->add($tuteurEtudiant);
            $tuteurEtudiant->setEtudiant($this);
        }

        return $this;
    }

    public function removeTuteurEtudiant(TuteurEtudiant $tuteurEtudiant): static
    {
        if ($this->tuteurEtudiants->removeElement($tuteurEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($tuteurEtudiant->getEtudiant() === $this) {
                $tuteurEtudiant->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AntecedentAcademique>
     */
    public function getAntecedentAcademiques(): Collection
    {
        return $this->antecedentAcademiques;
    }

    public function addAntecedentAcademique(AntecedentAcademique $antecedentAcademique): static
    {
        if (!$this->antecedentAcademiques->contains($antecedentAcademique)) {
            $this->antecedentAcademiques->add($antecedentAcademique);
            $antecedentAcademique->setEtudiant($this);
        }

        return $this;
    }

    public function removeAntecedentAcademique(AntecedentAcademique $antecedentAcademique): static
    {
        if ($this->antecedentAcademiques->removeElement($antecedentAcademique)) {
            // set the owning side to null (unless already changed)
            if ($antecedentAcademique->getEtudiant() === $this) {
                $antecedentAcademique->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bourse>
     */
    public function getBourses(): Collection
    {
        return $this->bourses;
    }

    public function addBourse(Bourse $bourse): static
    {
        if (!$this->bourses->contains($bourse)) {
            $this->bourses->add($bourse);
            $bourse->setEtudiant($this);
        }

        return $this;
    }

    public function removeBourse(Bourse $bourse): static
    {
        if ($this->bourses->removeElement($bourse)) {
            // set the owning side to null (unless already changed)
            if ($bourse->getEtudiant() === $this) {
                $bourse->setEtudiant(null);
            }
        }

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

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setEtudiant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEtudiant() === $this) {
                $note->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Incident>
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): static
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents->add($incident);
            $incident->setEtudiant($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): static
    {
        if ($this->incidents->removeElement($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getEtudiant() === $this) {
                $incident->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): static
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setEtudiant($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getEtudiant() === $this) {
                $presence->setEtudiant(null);
            }
        }

        return $this;
    }
}
