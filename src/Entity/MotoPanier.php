<?php

namespace App\Entity;

use App\Repository\MotoPanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotoPanierRepository::class)
 */
class MotoPanier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=Moto::class, inversedBy="motoPaniers")
     */
    private $Moto;

    /**
     * @ORM\ManyToOne(targetEntity=Panier::class, inversedBy="motoPaniers")
     */
    private $Panier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getMoto(): ?Moto
    {
        return $this->Moto;
    }

    public function setMoto(?Moto $Moto): self
    {
        $this->Moto = $Moto;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->Panier;
    }

    public function setPanier(?Panier $Panier): self
    {
        $this->Panier = $Panier;

        return $this;
    }
}
