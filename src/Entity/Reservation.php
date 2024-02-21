<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"The start date cannot be blank.")]
    #[Assert\GreaterThan(
         value:"today",
         message:"The start date must be after or on today")]
   
    private ?\DateTimeInterface $DateDebutR = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"The end date cannot be blank.")]
    #[Assert\Expression(
        "this.getDateFinR() >= this.getDateDebutR()",
        message:"The end date must be after the start date."
    )]
    
    private ?\DateTimeInterface $DateFinR = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"The number of people attending cannot be blank.")]
     #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    private ?int $NbrPerso = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Write room number and type : single,double or triple")]
    private ?string $TypeRoom = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $IdHotel = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"You ID attending cannot be blank.")]
     #[Assert\Regex(
        pattern:"/^\d+$/",
        message:"Only numbers are allowed"
    )]
    private ?string $IdClent = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: User::class)]
    private Collection $Client;

    public function __construct()
    {
        $this->Client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutR(): ?\DateTimeInterface
    {
        return $this->DateDebutR;
    }

    public function setDateDebutR(\DateTimeInterface $DateDebutR): static
    {
        $this->DateDebutR = $DateDebutR;

        return $this;
    }

    public function getDateFinR(): ?\DateTimeInterface
    {
        return $this->DateFinR;
    }

    public function setDateFinR(\DateTimeInterface $DateFinR): static
    {
        $this->DateFinR = $DateFinR;

        return $this;
    }

    public function getNbrPerso(): ?int
    {
        return $this->NbrPerso;
    }

    public function setNbrPerso(int $NbrPerso): static
    {
        $this->NbrPerso = $NbrPerso;

        return $this;
    }

    public function getTypeRoom(): ?string
    {
        return $this->TypeRoom;
    }

    public function setTypeRoom(string $TypeRoom): static
    {
        $this->TypeRoom = $TypeRoom;

        return $this;
    }

    public function getIdHotel(): ?Hotel
    {
        return $this->IdHotel;
    }

    public function setIdHotel(?Hotel $IdHotel): static
    {
        $this->IdHotel = $IdHotel;

        return $this;
    }

    public function getIdClent(): ?string
    {
        return $this->IdClent;
    }

    public function setIdClent(string $IdClent): static
    {
        $this->IdClent = $IdClent;

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
            $client->setReservation($this);
        }

        return $this;
    }

    public function removeClient(User $client): static
    {
        if ($this->Client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getReservation() === $this) {
                $client->setReservation(null);
            }
        }

        return $this;
    }
}
