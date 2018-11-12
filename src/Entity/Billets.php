<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletsRepository")
 */
class Billets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tarifs", inversedBy="billets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tarif;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_naissance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservations", inversedBy="billets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;


    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTarif(): Tarifs
    {
        return $this->tarif;
    }

    public function setTarif(Tarifs $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getDateDeNaissance(): \DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getReservation(): ?Reservations
    {
        return $this->reservation;
    }

    public function setReservation(?Reservations $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

  
}
