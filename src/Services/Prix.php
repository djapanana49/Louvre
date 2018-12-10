<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Tarifs;
use App\Entity\Billets;



class Prix{
 
    private function findPrice(Tarifs $tarifs, Billets $billets){
        
        $date = new Date($billets->getDateDeNaissance());
        $date2=new Date("now");
        $date->format('d/m/Y');
        $date2->format('d/m/Y');
       $interval=  $date->diff($date2);
       $age= (int)$interval->y;
       if($age >=12){
       $prix=$tarifs->get_id(2);
       return $prix;
       
       }
        else if ($age>=60){
         $prix=$tarifs->get_id(4);
        return $prix;
        }
        else if(($age>=4) &&($age <12)){
          $prix=$tarifs->get_id(3); 
        return $prix;
        }
       
    
    }
 
    
}