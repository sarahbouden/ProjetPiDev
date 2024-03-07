<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message:"User name is required")]
    private ?string $UserName = null;

    #[ORM\Column]
    private array $roles = [];
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message:"Password is required")]
    #[Assert\Length(
        min: 8,
        minMessage:"length should be 8")]
    private ?string $password = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank(message:"Cin is required")]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage:"length should be 8",
        maxMessage:"length should be 8")]
    private ?int $CIN = null;

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
    #[Assert\NotBlank(message:"Verify password is required")]
    #[Assert\EqualTo(propertyPath:"Password", message:"The passwords do not match")]
    private ?string $VPwd = null;

    #[ORM\ManyToOne(inversedBy: 'Client')]
    private ?Reservation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Challenge::class, mappedBy: 'Participants')]
    private Collection $challenges;

    #[ORM\ManyToOne(inversedBy: 'Client')]
    private ?Recompense $recompense = null;

    #[ORM\OneToMany(mappedBy: 'Users', targetEntity: Activite::class)]
    private Collection $activites;


    public function __construct()
    {
        $this->challenges = new ArrayCollection();
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->UserName;
    }

    public function setUserName(string $UserName): static
    {
        $this->UserName = $UserName;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Email;
    }

    
    /**
     * @see UserInterface
     */

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getVPwd(): ?string
    {
        return $this->VPwd;
    }

    public function setVPwd(string $VPwd): static
    {
        $this->VPwd = $VPwd;

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
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): static
    {
        $this->challenges->removeElement($challenge);

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

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setUsers($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getUsers() === $this) {
                $activite->setUsers(null);
            }
        }

        return $this;
    }

}