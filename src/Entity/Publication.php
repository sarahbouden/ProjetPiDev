<?php
namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez saisir le titre de la publication.")]
    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[Assert\NotBlank(message: "Veuillez saisir la description de la publication.")]
    #[ORM\Column(length: 255)]
    private ?string $Description = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir l'URL de la ressource.")]
    #[ORM\Column(length: 255)]
    private ?string $UrlRessource = null;

    #[ORM\Column(type: 'integer')]
    private ?int $rating = 0;

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     */
    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return int|null
     */
    public function getSomme(): ?int
    {
        return $this->somme;
    }

    /**
     * @param int|null $somme
     */
    public function setSomme(?int $somme): void
    {
        $this->somme = $somme;
    }
    #[ORM\Column(type: 'integer')]
    private ?int $somme = 0;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

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

    public function getUrlRessource(): ?string
    {
        return $this->UrlRessource;
    }

    public function setUrlRessource(string $UrlRessource): static
    {
        $this->UrlRessource = $UrlRessource;

        return $this;
    }

   
}
