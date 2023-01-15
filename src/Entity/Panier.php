<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Panier")
     */
    private $userpanier;

    /**
     * @ORM\OneToOne(targetEntity=Commande::class, cascade={"persist", "remove"})
     */
    private $Commande;

    /**
     * @ORM\OneToMany(targetEntity=MotoPanier::class, mappedBy="Panier")
     */
    private $motoPaniers;

    public function __construct()
    {
        $this->motoPaniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUserpanier(): ?User
    {
        return $this->userpanier;
    }

    public function setUserpanier(?User $userpanier): self
    {
        $this->userpanier = $userpanier;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): self
    {
        $this->Commande = $Commande;

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
            $motoPanier->setPanier($this);
        }

        return $this;
    }

    public function removeMotoPanier(MotoPanier $motoPanier): self
    {
        if ($this->motoPaniers->removeElement($motoPanier)) {
            // set the owning side to null (unless already changed)
            if ($motoPanier->getPanier() === $this) {
                $motoPanier->setPanier(null);
            }
        }

        return $this;
    }
}
