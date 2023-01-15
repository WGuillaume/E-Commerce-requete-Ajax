<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
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
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Adresse")
     */
    private $useradresse;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="adresseLivraison")
     */
    private $adresseLivraison;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="adresseFacture")
     */
    private $adresseFacture;

    public function __construct()
    {
        $this->adresseLivraison = new ArrayCollection();
        $this->adresseFacture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUseradresse(): ?User
    {
        return $this->useradresse;
    }

    public function setUseradresse(?User $useradresse): self
    {
        $this->useradresse = $useradresse;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getAdresseLivraison(): Collection
    {
        return $this->adresseLivraison;
    }

    public function addAdresseLivraison(Commande $adresseLivraison): self
    {
        if (!$this->adresseLivraison->contains($adresseLivraison)) {
            $this->adresseLivraison[] = $adresseLivraison;
            $adresseLivraison->setAdresseLivraison($this);
        }

        return $this;
    }

    public function removeAdresseLivraison(Commande $adresseLivraison): self
    {
        if ($this->adresseLivraison->removeElement($adresseLivraison)) {
            // set the owning side to null (unless already changed)
            if ($adresseLivraison->getAdresseLivraison() === $this) {
                $adresseLivraison->setAdresseLivraison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getAdresseFacture(): Collection
    {
        return $this->adresseFacture;
    }

    public function addAdresseFacture(Commande $adresseFacture): self
    {
        if (!$this->adresseFacture->contains($adresseFacture)) {
            $this->adresseFacture[] = $adresseFacture;
            $adresseFacture->setAdresseFacture($this);
        }

        return $this;
    }

    public function removeAdresseFacture(Commande $adresseFacture): self
    {
        if ($this->adresseFacture->removeElement($adresseFacture)) {
            // set the owning side to null (unless already changed)
            if ($adresseFacture->getAdresseFacture() === $this) {
                $adresseFacture->setAdresseFacture(null);
            }
        }

        return $this;
    }
}
