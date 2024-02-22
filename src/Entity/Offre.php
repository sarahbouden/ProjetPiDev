<?php

namespace App\Entity;
use App\Entity\Partenaire;
use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"Veuillez saisir le nom de l'offre.")]
    #[ORM\Column(length: 255)]
    private ?string $NomOffre = null;

    #[Assert\NotBlank(message:"Veuillez saisir la description de l'offre.")]
    #[ORM\Column(length: 255)]
    private ?string $DescriptionOffre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateExp = null;

    #[Assert\NotBlank(message:"Veuillez saisir le partenaire.")]
    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Partenaire $Partenaire = null;

    #[Assert\NotBlank(message:"Veuillez importer une photo.")]
    #[ORM\Column(length: 255)]
    private ?string $PhotoURL = null;

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

    public function getPhotoURL(): ?string
    {
        return $this->PhotoURL;
    }

    public function setPhotoURL(string $PhotoURL): static
    {
        $this->PhotoURL = $PhotoURL;

        return $this;
    }
    
}
