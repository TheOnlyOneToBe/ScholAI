<?php

namespace App\Entity;

use App\Repository\ImpressionFormatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImpressionFormatRepository::class)]
class ImpressionFormat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomFormat = null;

    #[ORM\Column(length: 255)]
    private ?string $largeurPage = null;

    #[ORM\Column]
    private ?float $longueurPage = null;

    #[ORM\Column(length: 150)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFormat(): ?string
    {
        return $this->nomFormat;
    }

    public function setNomFormat(string $nomFormat): static
    {
        $this->nomFormat = $nomFormat;

        return $this;
    }

    public function getLargeurPage(): ?string
    {
        return $this->largeurPage;
    }

    public function setLargeurPage(string $largeurPage): static
    {
        $this->largeurPage = $largeurPage;

        return $this;
    }

    public function getLongueurPage(): ?float
    {
        return $this->longueurPage;
    }

    public function setLongueurPage(float $longueurPage): static
    {
        $this->longueurPage = $longueurPage;

        return $this;
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
}
