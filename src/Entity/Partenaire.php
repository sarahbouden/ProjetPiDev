<?php

namespace App\Entity;

use App\Repository\PartenaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartenaireRepository::class)]
class Partenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomP = null;

    #[ORM\Column(length: 255)]
    private ?string $TypeP = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionP = null;

    #[ORM\OneToMany(mappedBy: 'Partenaire', targetEntity: Offre::class)]
    private Collection $offres;

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
    }
}
