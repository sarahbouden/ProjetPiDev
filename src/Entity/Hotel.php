<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NameH = null;

    #[ORM\Column(length: 255)]
    private ?string $Location = null;

    #[ORM\Column]
    private ?int $Rating = null;

    #[ORM\Column]
    private ?int $NumH = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $PhotoUrl = null;

    #[ORM\OneToMany(mappedBy: 'IdHotel', targetEntity: Reservation::class)]
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
}
