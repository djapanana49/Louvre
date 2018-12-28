<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Reservations;
use DateTime;

class Prix  {

    public function findPrice(Reservations $reservations) {
        
        $billets = $reservations->getBillets();
            foreach ($billets as $billet) {
                $date = $billet->getDateDeNaissance();
                $date2 = new DateTime("now");
                $date->format('d/m/Y');
                $date2->format('d/m/Y');
                $interval = $date->diff($date2);
                $age = (int) $interval->y;
                    if ($billet->getReduit()==true){
                        $prix=$billet->setTarif(10);
                    }
                    else if ($age >= 12) {
                        $prix = $billet->setTarif(16);
                    } else if ($age >= 60) {
                        $prix = $billet->setTarif(12);
                    } else if (($age >= 4) && ($age < 12)) {
                        $prix = $billet->setTarif(8);
                    }
                    else if (($age == 0) && ($age < 4)) {
                        $prix = $billet->setTarif(0);
                    }
        }
    }

}
