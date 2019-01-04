<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Reservations;
use DateTime;

/**
 * Description of CheckJournee
 * Vérification des réservations le jour même
 *
 * @author SYLVIE
 */
class CheckJournee {
    
    /**
     *
     * @var type Reservations
     */
    
    private $reservation;
    
    public function __construct(Reservations $reservation) {
        $this->reservation = $reservation;
    }
    
    public function CheckJournee(){
     $date=$this->reservation->getDateVisite();
     $date2=$this->reservation->getDateReservation();
     $date->format('d/m/Y');
     $date2->format('d/m/Y');
     $interval = $date->diff($date2);
     $heure= new DateTime('today');
     $heure->setTime(11,0);
     $heure2= new DateTime('now');
     $heure2->format('H:i');
     if(($interval->d===0)&& (($heure2 >$heure)==true))
     {
        
         return false;// Demi-journée
         
     }
     else {
          
         return true;// Journée
     }
    }
}
