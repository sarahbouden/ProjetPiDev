<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
#[Vich\Uploadable]


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

    #[Vich\UploadableField(mapping: 'Activites_images', fileNameProperty: 'imageName',)]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    
    #[Assert\NotBlank ( message: "Type is required")]
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



    #[ORM\ManyToMany(targetEntity: Challenge::class, mappedBy: 'Activity')]
    private Collection $challenges;

    #[ORM\OneToMany(mappedBy: 'activites', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoris')]
    private Collection $Favoris;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    private ?User $Users = null;


    

   
    public function __construct()
    {
        $this->challenges = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->Favoris = new ArrayCollection();
        
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

    public function setImageFile(?File $imageFile ): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
        
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setActivites($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getActivites() === $this) {
                $comment->setActivites(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->Favoris;
    }

    public function addFavori(User $favori): static
    {
        if (!$this->Favoris->contains($favori)) {
            $this->Favoris->add($favori);
        }

        return $this;
    }
    

    public function removeFavori(User $favori): static
    {
        $this->Favoris->removeElement($favori);

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->Users;
    }

    public function setUsers(?User $Users): static
    {
        $this->Users = $Users;

        return $this;
    }
   

   
}
