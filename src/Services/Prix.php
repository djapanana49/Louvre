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

        foreach ($billets as $billet) {

           
            $date = $billet->getDateDeNaissance();
            $date2 = new DateTime("now");
            $date->format('d/m/Y');
            $date2->format('d/m/Y');
            $interval = $date->diff($date2);
            $age = (int) $interval->y;
 
            if ($age >= 12) {
                $tarifs = $repository->findPriceId(2);
                $prix = $billet->setTarif($tarifs);
                return $prix;
            } else if ($age >= 60) {
                $tarifs = $repository->findPriceId(4);
                $prix = $billet->setTarif($tarifs);
                return $prix;
            } else if (($age >= 4) && ($age < 12)) {
                $tarifs = $repository->findPriceId(3);
                $prix = $billet->setTarif($tarifs);
                return $prix;
            }
        }
    }

}
