<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

class SendMail
{
    
   public function MailConfirmation($name, $email,Swift_Mailer $mailer)
{
    $message = (new Swift_Message('Réservation de billet(s)'))
        ->setFrom('sylvianna@free.fr')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                // templates/emails/confirmation.html.twig
                'EmailsConfirmation.html.twig',
                array('name' => $name,
                )
            ),
            'text/html'
        )
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
    ;

    $mailer->send($message);

    return $this->render('accueil');
}
}