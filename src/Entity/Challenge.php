<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 


#[ORM\Entity(repositoryClass: ChallengeRepository::class)]
class Challenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank (message: "Titre is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: false)]
 
    private ?string $TitreCh =  null;

    #[Assert\NotBlank (message: "DateDebut is required")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    
    private ?\DateTimeInterface $DateDebutCh = null;

    #[Assert\NotBlank (message: "DateFin is required")]
    #[Assert\GreaterThan(propertyPath: "DateDebutCh", message: "La date de fin doit être après la date de début.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
   
    private ?\DateTimeInterface $DateFinCh = null;

    #[Assert\NotBlank (message: "Objectif is required")]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
 
    private ?string $ObjectifCh = null;

#[Assert\NotBlank (message: "Participant is required")]
    
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'challenges')]
    
    private Collection $Participants;

    #[Assert\NotBlank (message: "Activity is required")]
    
    #[ORM\ManyToMany(targetEntity: Activite::class, inversedBy: 'challenges')]
   
    private Collection $Activity;

    public function __construct()
    {
        $this->Participants = new ArrayCollection();
        $this->Activity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCh(): ?string
    {
        return $this->TitreCh;
    }
    public function __toString(): string
    {
        return $this->getTitreCh() ?: 'N/A';
    }

    public function setTitreCh(string $TitreCh): static
    {
        $this->TitreCh = $TitreCh;

        return $this;
    }

    public function getDateDebutCh(): ?\DateTimeInterface
    {
        return $this->DateDebutCh;
    }

    public function setDateDebutCh(\DateTimeInterface $DateDebutCh): static
    {
        $this->DateDebutCh = $DateDebutCh;

        return $this;
    }

    public function getDateFinCh(): ?\DateTimeInterface
    {
        return $this->DateFinCh;
    }

    public function setDateFinCh(\DateTimeInterface $DateFinCh): static
    {
        $this->DateFinCh = $DateFinCh;

        return $this;
    }

    public function getObjectifCh(): ?string
    {
        return $this->ObjectifCh;
    }

    public function setObjectifCh(string $ObjectifCh): static
    {
        $this->ObjectifCh = $ObjectifCh;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }
    


    public function addParticipant(User $participant): static
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(User $participant): static
    {
        $this->Participants->removeElement($participant);

        return $this;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivity(): Collection
    {
        return $this->Activity;
    }

    public function addActivity(Activite $activity): static
    {
        if (!$this->Activity->contains($activity)) {
            $this->Activity->add($activity);
        }

        return $this;
    }

    public function removeActivity(Activite $activity): static
    {
        $this->Activity->removeElement($activity);

        return $this;
    }
}
