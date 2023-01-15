<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
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
     * @ORM\Column(type="boolean")
     */
    private $payee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $retrait;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Commande")
     */
    private $usercommande;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="adresseLivraison")
     */
    private $adresseLivraison;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="adresseFacture")
     */
    private $adresseFacture;

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

    public function isPayee(): ?bool
    {
        return $this->payee;
    }

    public function setPayee(bool $payee): self
    {
        $this->payee = $payee;

        return $this;
    }

    public function isRetrait(): ?bool
    {
        return $this->retrait;
    }

    public function setRetrait(bool $retrait): self
    {
        $this->retrait = $retrait;

        return $this;
    }

    public function getUsercommande(): ?User
    {
        return $this->usercommande;
    }

    public function setUsercommande(?User $usercommande): self
    {
        $this->usercommande = $usercommande;

        return $this;
    }

    public function getAdresseLivraison(): ?Adresse
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?Adresse $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getAdresseFacture(): ?Adresse
    {
        return $this->adresseFacture;
    }

    public function setAdresseFacture(?Adresse $adresseFacture): self
    {
        $this->adresseFacture = $adresseFacture;

        return $this;
    }
}
