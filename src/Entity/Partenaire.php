<?php

namespace App\Entity;

use App\Repository\PartenaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;*/


#[ORM\Entity(repositoryClass: PartenaireRepository::class)]
/**#[ORM\Entity]
#[UniqueEntity('titre')]*/
class Partenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"Veuillez saisir le nom paretenaire.")]
    #[ORM\Column(length: 255)]
    private ?string $NomP = null;

    #[Assert\NotBlank(message:"Veuillez saisir le type de partenaire.")]
    #[ORM\Column(length: 255)]
    private ?string $TypeP = null;
    
    #[Assert\NotBlank(message:"Veuillez saisir le description de partenaire.")]
    #[ORM\Column(length: 255)]
    private ?string $DescriptionP = null;

   

    #[Assert\NotBlank(message:"Veuillez saisir une adresse.")]
    #[ORM\Column(length: 255)]
    private $address;

    #[Assert\NotBlank(message:"Veuillez saisir une photo.")]
    #[ORM\Column(length: 255)]
    private ?string $PhotoUrl = null;
    
    #[ORM\OneToMany(mappedBy: 'Partenaire', targetEntity: Offre::class)]
    private Collection $offres;

   

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $longitude;


    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->NomP;
    }

    public function setNomP(string $NomP): static
    {
        $this->NomP = $NomP;

        return $this;
    }

    public function getTypeP(): ?string
    {
        return $this->TypeP;
    }

    public function setTypeP(string $TypeP): static
    {
        $this->TypeP = $TypeP;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->DescriptionP;
    }

    public function setDescriptionP(string $DescriptionP): static
    {
        $this->DescriptionP = $DescriptionP;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): static
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setPartenaire($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getPartenaire() === $this) {
                $offre->setPartenaire(null);
            }
        }

        return $this;
    }public function __toString():string{
        return $this->id;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->PhotoUrl;
    }

    public function setPhotoUrl(string $PhotoUrl): static
    {
        $this->PhotoUrl = $PhotoUrl;

        return $this;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
