<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of CheckSession
 *
 * @author djapa
 */
class CheckSession {
   
  
    public function checkSession(){
        
      $session = new Session();
      $reservation = $session->get('session_billets');
      
            if($reservation==null){

                $this->addFlash('danger','Vous n\'avez pas accès à cette page');
                return $this->redirectToRoute('accueil');

            }
             else{

                 $billets = $reservation->getBillets();
             } 
         
        }
}
