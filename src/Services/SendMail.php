<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Swift_Attachment;
use Swift_Image;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class SendMail {
    /**
     *
     * @var type Swift_Mailer
     */
    private $mailer;
    
    /**
     *
     * @var type Environment
     */
    private $renderer;

    public function __construct(Swift_Mailer $mailer, Environment $renderer) {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function MailConfirmation($reservation, $billets) {
        
        $message = new Swift_Message('Réservation de billet(s)');
        //Création du message envoyé par mail
        $cid = $message->embed(Swift_Image::fromPath('images/Logo_louvre.png'));
        $message->setFrom('Reservations@Louvre.fr')
                ->setTo($reservation->getMail())
                ->attach(Swift_Attachment::fromPath('images/Logo_louvre.png'))
                ->setBody(
                $this->renderer->render(
                        // templates/emails/confirmation.html.twig
                        'louvre/EmailsConfirmation.html.twig', [
                    'recap' => $reservation,
                    'billets' => $billets,
                     'cid'=>$cid,
                ]),
                'text/html'
        );
        $this->mailer->send($message);
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
