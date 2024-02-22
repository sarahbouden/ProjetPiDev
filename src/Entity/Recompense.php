<?php

namespace App\Entity;

use App\Repository\RecompenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecompenseRepository::class)]
class Recompense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomRecp = null;

    #[ORM\Column(length: 255)]
    private ?string $Niveau = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionRecp = null;

    #[ORM\OneToMany(mappedBy: 'recompense', targetEntity: User::class)]
    private Collection $Client;

    public function __construct()
    {
        $this->Client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRecp(): ?string
    {
        return $this->NomRecp;
    }

    public function setNomRecp(string $NomRecp): static
    {
        $this->NomRecp = $NomRecp;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->Niveau;
    }

    public function setNiveau(string $Niveau): static
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getDescriptionRecp(): ?string
    {
        return $this->DescriptionRecp;
    }

    public function setDescriptionRecp(string $DescriptionRecp): static
    {
        $this->DescriptionRecp = $DescriptionRecp;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getClient(): Collection
    {
        return $this->Client;
    }

    public function addClient(User $client): static
    {
        if (!$this->Client->contains($client)) {
            $this->Client->add($client);
            $client->setRecompense($this);
        }

        return $this;
    }

    public function removeClient(User $client): static
    {
        if ($this->Client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getRecompense() === $this) {
                $client->setRecompense(null);
            }
        }

        return $this;
    }
}
