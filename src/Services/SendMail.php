<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Swift_Mailer;
use Swift_Message;

class SendMail
{
   
   
   public function MailConfirmation($reservation,$billets,$mail)
{
        //Création du message envoyé par mail
        $message = (new Swift_Message('Réservation de billet(s)'))
                ->setFrom('sylvianna@free.fr')
                ->setTo($mail)
                ->setBody(
                $this->renderView(
                        // templates/emails/confirmation.html.twig
                        'louvre/EmailsConfirmation.html.twig', [
                    'recap' => $reservation,
                    'billets' => $billets,
                ]),
                'text/html'
        );
        $mailer->send($message);
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
}
}