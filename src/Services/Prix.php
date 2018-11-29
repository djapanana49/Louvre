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
 
    function findPrice(Tarifs $tarifs, Billets $billets){
        
        $date = new Date("02/10/1969");
        $date2=new Date("now");
        $date->format('d/m/Y');
        $date2->format('d/m/Y');
       $interval=  $date->diff($date2);
       $age= (int)$interval->y;
       if($age >=12){
       $tarifs->type_tarifs("Normal");
       
       }
        else if ($age>=60)
        $tarifs->type_tarifs("Séniors");
        
        else if(($age>=4) &&($age <12))
         $tarifs->type_tarifs("Enfants");   
        
        
    }
       
    
  
 
    
}