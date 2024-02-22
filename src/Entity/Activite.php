<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 


#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[Assert\NotBlank (message: "Nom is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $NomAct = null;

    #[Assert\NotBlank (message: "Type is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $TypeAct = null;

    #[Assert\NotBlank(message: "Location is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $LocationAct = null;

    #[Assert\NotBlank(message: "Description is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $DescriptionAct = null;

    #[Assert\NotBlank(message: "URL is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $PhotoUrl = null;

    #[ORM\ManyToMany(targetEntity: Challenge::class, mappedBy: 'Activity')]
    private Collection $challenges;

    public function __construct()
    {
        $this->challenges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAct(): ?string
    {
        return $this->NomAct;
    }
    public function __toString(): string
    {
        return $this->getNomAct() ?: 'N/A';
    }

    public function setNomAct(string $NomAct): static
    {
        $this->NomAct = $NomAct;

        return $this;
    }

    public function getTypeAct(): ?string
    {
        return $this->TypeAct;
    }

    public function setTypeAct(string $TypeAct): static
    {
        $this->TypeAct = $TypeAct;

        return $this;
    }

    public function getLocationAct(): ?string
    {
        return $this->LocationAct;
    }

    public function setLocationAct(string $LocationAct): static
    {
        $this->LocationAct = $LocationAct;

        return $this;
    }

    public function getDescriptionAct(): ?string
    {
        return $this->DescriptionAct;
    }

    public function setDescriptionAct(string $DescriptionAct): static
    {
        $this->DescriptionAct = $DescriptionAct;

        return $this;
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

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): static
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges->add($challenge);
            $challenge->addActivity($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): static
    {
        if ($this->challenges->removeElement($challenge)) {
            $challenge->removeActivity($this);
        }

        return $this;
    }
}
