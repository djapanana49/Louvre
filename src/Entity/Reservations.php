<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\JoursFermes;
use App\Validator\Journee;
use App\Validator\CheckNbBillets;
//use App\Validator\MilleBillets;
use DateTimeZone;
use DateTime;


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
     * @Assert\DateTime
     * @Assert\GreaterThanOrEqual("today",
     * message="Les réservations pour des dates passées sont interdites ")
     * @JoursFermes
     * @CheckNbBillets
     */
    private $date_visite;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $date_reservation;

    /**
     * @ORM\Column(type="integer")
     * * @Assert\Range(
     *      min = 1,
     *      max = 20,
     *      minMessage = "vous devez choisir au moins {{ limit }} billet",
     *      maxMessage = "Vous ne pouvez pas choisir plus de {{ limit }} billets"
     * )
     * @Assert\Type(
     *     type="integer",
     *     message="La valeur {{ value }} n\'est pas un {{ type }}."
     * )
     */
    private $nb_billets;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "L\'email '{{ value }}' n\'est pas valide.",
     *     checkMX = true
     * )
     * 
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity="Billets", mappedBy="reservation",cascade={"persist"})
     * 
     */
    private $billets;

    /**
     * @ORM\Column(type="boolean")
     * @Journee
     */
    private $journee;
   
    public function __construct()
    {
        $this->billets = new ArrayCollection();
        $this->setDateReservation(new DateTime('now',new DateTimeZone('Europe/Paris')));
        $this->setNumReservation(uniqid(). time());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumReservation()
    {
        return $this->num_reservation;
    }

    public function setNumReservation(string $num_reservation="")
    {
        $this->num_reservation = $num_reservation;

        return $this;
    }

    public function getDateVisite()
    {
        return $this->date_visite;
    }

    public function setDateVisite(DateTime $date_visite=null)
    {
        $this->date_visite = $date_visite;

        return $this;
    }

    public function getDateReservation()
    {
        return $this->date_reservation;
    }

    public function setDateReservation(DateTime $date_reservation = null)
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getNbBillets()
    {
        return $this->nb_billets;
    }

    public function setNbBillets(int $nb_billets)
    {
        $this->nb_billets = $nb_billets;

        return $this;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail(string $mail)
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

    public function addBillet(Billets $billet)
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setReservation($this);
        }

        return $this;
    }

    public function removeBillet(Billets $billet)
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

    public function getJournee()
    {
        return $this->journee;
    }

    public function setJournee(bool $journee): self
    {
        $this->journee = $journee;

        return $this;
    }
    
   
}
