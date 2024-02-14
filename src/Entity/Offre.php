<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomOffre = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionOffre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateExp = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Partenaire $Partenaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOffre(): ?string
    {
        return $this->NomOffre;
    }

    public function setNomOffre(string $NomOffre): static
    {
        $this->NomOffre = $NomOffre;

        return $this;
    }

    public function getDescriptionOffre(): ?string
    {
        return $this->DescriptionOffre;
    }

    public function setDescriptionOffre(string $DescriptionOffre): static
    {
        $this->DescriptionOffre = $DescriptionOffre;

        return $this;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->DateExp;
    }

    public function setDateExp(\DateTimeInterface $DateExp): static
    {
        $this->DateExp = $DateExp;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->Partenaire;
    }

    public function setPartenaire(?Partenaire $Partenaire): static
    {
        $this->Partenaire = $Partenaire;

        return $this;
    }
}
