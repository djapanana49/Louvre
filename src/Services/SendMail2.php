<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use SendGrid;
use Symfony\Component\Config\Definition\Exception\Exception;
use Twig\Environment;

class SendMail2 {
   
    /**
     *
     * @var type Environment
     */
    private $renderer;

    public function __construct(Environment $renderer) {

        $this->renderer = $renderer;
    }

    public function MailConfirmation($reservation, $billets) {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("Reservation@louvre.fr", "Confirmation de réservation");
        $email->setSubject("Votre réservation");
        $email->addTo("sylvienana46@gmail.com", "Votre réservation");
        $email->addContent( $this->renderer->render(
                        // templates/emails/confirmation.html.twig
                     array('louvre/EmailsConfirmation.html.twig', 
                    'recap' => $reservation,
                    'billets' => $billets,)   
                   
                ),
                'text/html'
        );
        $sendgrid = new \SendGrid('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');

        try {
            $response = $sendgrid->send($email);
            echo'<pre>';
            var_dump($response);die;
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
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
        catch (Exception $e){
            echo $e->getMessage();
        }      
    }

}
