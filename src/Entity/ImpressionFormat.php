<?php

namespace App\Entity;

use App\Repository\ImpressionFormatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ImpressionFormatRepository::class)]
#[UniqueEntity(
    fields: ['nomFormat'],
    message: 'impression_format.nom_format.unique'
)]
class ImpressionFormat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'impression_format.nom_format.not_blank')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'impression_format.nom_format.min_length',
        maxMessage: 'impression_format.nom_format.max_length'
    )]
    private ?string $nomFormat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'impression_format.largeur_page.not_blank')]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d+)?(mm|cm|in)$/',
        message: 'impression_format.largeur_page.invalid_format'
    )]
    private ?string $largeurPage = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'impression_format.longueur_page.not_null')]
    #[Assert\GreaterThan(
        value: 0,
        message: 'impression_format.longueur_page.must_be_positive'
    )]
    private ?float $longueurPage = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'impression_format.description.not_blank')]
    #[Assert\Length(
        min: 10,
        max: 150,
        minMessage: 'impression_format.description.min_length',
        maxMessage: 'impression_format.description.max_length'
    )]
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
