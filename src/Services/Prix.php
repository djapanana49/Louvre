<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Billets;
use App\Entity\Reservations;
use App\Entity\Tarifs;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Prix extends AbstractController {

    public function findPrice(Reservations $reservations) {


        $repository = $this->getDoctrine()->getRepository(Tarifs::class);
        $billets = $reservations->getBillets();
        $nb=$reservations->getNbBillets();

        foreach($billets as $billet) {

           var_dump('date :',$billet->getDateDeNaissance());
            $date = $billet->getDateDeNaissance();
            $date2 = new DateTime("now");
            $date->format('d/m/Y');
            $date2->format('d/m/Y');
            $interval = $date->diff($date2);
            $age = (int) $interval->y;

            if ($age >= 12) {

                $prix = $billet->setTarif(16);

            } else if ($age >= 60) {

                $prix = $billet->setTarif(12);

            } else if (($age >= 4) && ($age < 12)) {

                $prix = $billet->setTarif(8);

            }
        }
    }

}
