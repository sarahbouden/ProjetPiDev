<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Name is required")]
    #[Assert\Type(
        type: 'string',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    private ?string $NameH = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Location is required")]
    #[Assert\Type(
        type: 'string',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    private ?string $Location = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Rating is required")]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[Assert\Range(
        min: 0,
        max: 5,
        notInRangeMessage: 'You must rate on a scale from 0 to 5 ',
    )]
    private ?int $Rating = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"The hotel number is required")]
    private ?int $NumH = null;

    #[ORM\Column(length: 9000)]
    #[Assert\NotBlank(message:"The description is required")]
    #[Assert\Type('string')]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"The photo is required")]
    #[Assert\Url(
        message: 'The url {{ value }} is not a valid url',
    )]
    private ?string $PhotoUrl = null;

    #[ORM\OneToMany(mappedBy: 'IdHotel', targetEntity: Reservation::class,cascade:['all'],orphanRemoval:true)]
    private Collection $reservation;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameH(): ?string
    {
        return $this->NameH;
    }

    public function setNameH(string $NameH): static
    {
        $this->NameH = $NameH;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): static
    {
        $this->Location = $Location;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->Rating;
    }

    public function setRating(int $Rating): static
    {
        $this->Rating = $Rating;

        return $this;
    }

    public function getNumH(): ?int
    {
        return $this->NumH;
    }

    public function setNumH(int $NumH): static
    {
        $this->NumH = $NumH;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

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
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setIdHotel($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getIdHotel() === $this) {
                $reservation->setIdHotel(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNameH(); // Retourne le nom de l'hôtel (ou toute autre représentation significative)
    }
}
