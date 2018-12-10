<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifsRepository")
 */
class Tarifs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_tarif;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billets", mappedBy="tarif")
     */
    private $billets;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

public function getId()
    {
        return $this->id;
    }

    public function getTypeTarif(): string
    {
        return $this->type_tarif;
    }

    public function setTypeTarif(string $type_tarif): self
    {
        $this->type_tarif = $type_tarif;

        return $this;
    }

    public function getTarif(): int
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * @return Collection|Billets[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billets $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setTarif($this);
        }

        return $this;
    }

    public function removeBillet(Billets $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getTarif() === $this) {
                $billet->setTarif(null);
            }
        }

        return $this;
    }
}
