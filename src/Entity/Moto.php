<?php

namespace App\Entity;

use App\Repository\MotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotoRepository::class)
 */
class Moto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $km;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $puissance;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="Moto")
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="motos")
     */
    private $Marque;

    /**
     * @ORM\OneToMany(targetEntity=MotoPanier::class, mappedBy="Moto")
     */
    private $motoPaniers;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->motoPaniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setMoto($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getMoto() === $this) {
                $photo->setMoto(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->Marque;
    }

    public function setMarque(?Marque $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    /**
     * @return Collection<int, MotoPanier>
     */
    public function getMotoPaniers(): Collection
    {
        return $this->motoPaniers;
    }

    public function addMotoPanier(MotoPanier $motoPanier): self
    {
        if (!$this->motoPaniers->contains($motoPanier)) {
            $this->motoPaniers[] = $motoPanier;
            $motoPanier->setMoto($this);
        }

        return $this;
    }

    public function removeMotoPanier(MotoPanier $motoPanier): self
    {
        if ($this->motoPaniers->removeElement($motoPanier)) {
            // set the owning side to null (unless already changed)
            if ($motoPanier->getMoto() === $this) {
                $motoPanier->setMoto(null);
            }
        }

        return $this;
    }
}
