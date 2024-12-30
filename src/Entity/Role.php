<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[UniqueEntity(
    fields: ['nomRole'],
    message: 'role.nom_role.unique'
)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'role.nom_role.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'role.nom_role.min_length',
        maxMessage: 'role.nom_role.max_length'
    )]
    #[Assert\Regex(
        pattern: '/^ROLE_[A-Z_]+$/',
        message: 'role.nom_role.invalid_format'
    )]
    private ?string $nomRole = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'role')]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRole(): ?string
    {
        return $this->nomRole;
    }

    public function setNomRole(string $nomRole): static
    {
        $this->nomRole = $nomRole;

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
            $utilisateur->setRole($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getRole() === $this) {
                $utilisateur->setRole(null);
            }
        }

        return $this;
    }
}
