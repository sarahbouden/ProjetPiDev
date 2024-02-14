<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChallengeRepository::class)]
class Challenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreCh = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebutCh = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFinCh = null;

    #[ORM\Column(length: 255)]
    private ?string $ObjectifCh = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'challenges')]
    private Collection $Participants;

    #[ORM\ManyToMany(targetEntity: Activité::class, inversedBy: 'challenges')]
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
     * @return Collection<int, Activité>
     */
    public function getActivity(): Collection
    {
        return $this->Activity;
    }

    public function addActivity(Activité $activity): static
    {
        if (!$this->Activity->contains($activity)) {
            $this->Activity->add($activity);
        }

        return $this;
    }

    public function removeActivity(Activité $activity): static
    {
        $this->Activity->removeElement($activity);

        return $this;
    }
}
