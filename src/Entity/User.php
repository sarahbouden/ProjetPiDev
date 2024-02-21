<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique:true)]
    #[Assert\NotBlank(message:"Cin is required")]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage:"length should be 8",
        maxMessage:"length should be 8")]
    private ?int $CIN = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"User name is required")]
    private ?string $UserName = null;

    #[ORM\Column(length: 255, unique:true)]
    #[Assert\NotBlank(message:"Email is required")]
    #[Assert\Email(message:"The email '{{value}}' is not a valid email")]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Adresse is required")]

    private ?string $Adresse = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Phone number is required")]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage:"length should be 8",
        maxMessage:"length should be 8")]
    private ?int $NumTel = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Cin is required")]
    private ?string $Pwd = null;

    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    #[ORM\ManyToOne(inversedBy: 'Client')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Reservation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Challenge::class, mappedBy: 'Participants')]
    private Collection $challenges;

    #[ORM\ManyToOne(inversedBy: 'Client')]
    private ?Recompense $recompense = null;

    public function __construct()
    {
        $this->challenges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCIN(): ?int
    {
        return $this->CIN;
    }

    public function setCIN(int $CIN): static
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->UserName;
    }

    public function setUserName(string $UserName): static
    {
        $this->UserName = $UserName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->NumTel;
    }

    public function setNumTel(int $NumTel): static
    {
        $this->NumTel = $NumTel;

        return $this;
    }

    public function getPwd(): ?string
    {
        return $this->Pwd;
    }

    public function setPwd(string $Pwd): static
    {
        $this->Pwd = $Pwd;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

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
            $challenge->addParticipant($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): static
    {
        if ($this->challenges->removeElement($challenge)) {
            $challenge->removeParticipant($this);
        }

        return $this;
    }

    public function getRecompense(): ?Recompense
    {
        return $this->recompense;
    }

    public function setRecompense(?Recompense $recompense): static
    {
        $this->recompense = $recompense;

        return $this;
    }
}
