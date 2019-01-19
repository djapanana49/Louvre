<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Service pour calcul du prix
 */

namespace App\Services;

use App\Entity\Reservations;
use DateTime;

class Prix  {

    public function findPrice(Reservations $reservations) {
        
        $billets = $reservations->getBillets();
            foreach ($billets as $billet) {
                $date = $billet->getDateDeNaissance();// récupération des dates de naissance
                $date2 = new DateTime("now");
                $date->format('d/m/Y');
                $date2->format('d/m/Y');
                $interval = $date->diff($date2);// calcul de l'âge
                $age = (int) $interval->y; // âge en années
                
                // billet journée 
                if($reservations->getJournee()===true){ 
                    
                // Tarif réduit ou pas 
                    if ($billet->getReduit()===true){
                        $billet->setTarif(10);
                    }
                    else if (($age >= 12)&&($age<60)){
                        $billet->setTarif(16);
                    } else if ($age >= 60) {
                        $billet->setTarif(12);
                    } else if (($age >= 4) && ($age < 12)) {
                        $billet->setTarif(8);
                    }
                    else if (($age >=0) && ($age < 4)) {
                        $billet->setTarif(0);
                        
                    }
                }
                //billet demi-journée
                else {
                     
                    if ($billet->getReduit()===true){
                        $billet->setTarif(5);
                    }
                    else if ($age >= 12) {
                        $billet->setTarif(8);
                    } else if ($age >= 60) {
                        $billet->setTarif(6);
                    } else if (($age >= 4) && ($age < 12)) {
                        $billet->setTarif(4);
                    }
                    else if (($age  >=0) && ($age < 4)) {
                        $billet->setTarif(0);
                    }
                    
                }
     }
    }

}
