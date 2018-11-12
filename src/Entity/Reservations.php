<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationsRepository")
 */
class Reservations
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
    private $num_reservation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_visite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_reservation;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_billets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billets", mappedBy="reservation")
     */
    private $billets;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumReservation(): string
    {
        return $this->num_reservation;
    }

    public function setNumReservation(string $num_reservation): self
    {
        $this->num_reservation = $num_reservation;

        return $this;
    }

    public function getDateVisite(): \DateTimeInterface
    {
        return $this->date_visite;
    }

    public function setDateVisite(\DateTimeInterface $date_visite): self
    {
        $this->date_visite = $date_visite;

        return $this;
    }

    public function getDateReservation(): \DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getNbBillets(): int
    {
        return $this->nb_billets;
    }

    public function setNbBillets(int $nb_billets): self
    {
        $this->nb_billets = $nb_billets;

        return $this;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
            $billet->setReservation($this);
        }

        return $this;
    }

    public function removeBillet(Billets $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getReservation() === $this) {
                $billet->setReservation(null);
            }
        }

        return $this;
    }
}
