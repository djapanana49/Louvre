<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\NotNull
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotNull
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(
     *     type="integer",
     *     message="La valeur {{ value }} n'est pas une valeur valide {{ type }}."
     * )
     */
    private $tarif;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(
     *     message = "Ce n\'est pas une date de naissance valide.",
     * )
     */
    private $date_de_naissance;
    
     /**
     * @ORM\Column(type="string", length=100)
     * 
     */
    private $Pays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservations", inversedBy="billets")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     */
    private $reservation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reduit;

   


    public function getId(): int
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTarif()
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getDateDeNaissance()
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getReservation(): Reservations
    {
        return $this->reservation;
    }

    public function setReservation(Reservations $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getPays()
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getReduit()
    {
        return $this->reduit;
    }

    public function setReduit(bool $reduit): self
    {
        $this->reduit = $reduit;

        return $this;
    }

  
}
