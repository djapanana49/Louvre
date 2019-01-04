<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\Tarifs;
use App\Form\ReservationType;
use App\Services\CheckJournee;
use App\Services\Prix;
use App\Services\SendMail;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class LouvreController extends AbstractController {

    /**
     * @Route("/louvre", name="louvre")
     */
    public function index() {
        return $this->render('louvre/index.html.twig', [
                    'controller_name' => 'LouvreController',
        ]);
    }

    /**
     * @Route("/", name="accueil")
     */
    public function accueil() {
        //Affichage des prix sur la page d'accueil
        $prix = new Tarifs();
        $prix = $this->getDoctrine()->getRepository(Tarifs::class)->findAll();
        return $this->render('louvre/accueil.html.twig', array(
                    'prix' => $prix)
        );
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function newReservation(Request $request) {

        $reservation = new Reservations();
        $session = new Session();
       //$JourneeValidator=new JourneeValidator();
       //$check = new CheckJournee();
       $prix_billet = new Prix();

        //création du formulaire
        $form = $this->createForm(ReservationType::class, $reservation);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        if ($form->isSubmitted() && $form->isValid()) {
           
                
             //vérification de la réservation le jour même 
           // $reservation->setJournee($check->CheckJournee($reservation));
            
            $NbBillets = $this->getDoctrine()
            ->getRepository(Reservations::class)
            ->SumTicket($reservation->getDateVisite());
            if($NbBillets >10){
            //Récupération des prix en fonction de la date de naissance
            $prix_billet->findPrice($reservation);
            }
            else{
                
                echo'Trop de billets vendus pour cette date';die;
            }
            //création de la session $reservation

            if ($request->hasSession() && ($session = $request->getSession())) {
                $session->set('session_billets', $reservation);
               
            }
           
            return $this->redirectToRoute('recapitulatif');
        }
        // Création du formulaire de réservation dans le fichier twig
        return $this->render('louvre/reservation.html.twig', [
                    'formReservation' => $form->createView(),
        ]);
        // ...
    }

    /**
     * @Route("/recapitulatif", name="recapitulatif")
     */
    public function Recap() {

        $session = new Session();
        $reservation = $session->get('session_billets');
        $billets = $reservation->getBillets();
        return $this->render('louvre/recapitulatif.html.twig', [
                    'recap' => $reservation,
                    'billets' => $billets,
        ]);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment(SendMail $confirmation) {

        $session = new Session();
        //Récupération de la session
        $reservation = $session->get('session_billets');
        //Récupération de l'adresse mail
        $mail = filter_input(\INPUT_POST, 'email');
        //Récupération de tous les billets
        $billets = $reservation->getBillets();

        //Insertion de l'email dans $reservation
        $reservation->setMail($mail);

        $entityManager = $this->getDoctrine()->getManager();

        // Récupérer le montant TTC pour le mettre dans le paiement stripe        
        $prixTTC = filter_input(\INPUT_POST, 'total') * 100;

        // Récupérer le token de paiement
        $token = filter_input(\INPUT_POST, 'stripeToken');

        Stripe::setApiKey("sk_test_NMS8iaVWh2STD5FqTP9PCeZz");


        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:

        Charge::create([
            'amount' => $prixTTC,
            'currency' => 'eur',
            'description' => 'Paiement final',
            'source' => $token,
            'receipt_email' => 'djapanana@free.fr',
        ]);

        // Insertion dans la base de données
        $entityManager->persist($reservation);
        $entityManager->flush();

        //Envoi de la confirmation par mail
        $confirmation->MailConfirmation($reservation, $billets);
        $this->addFlash(
            'notice',
            'Mail de confirmation envoyé'
        );
       return $this->redirectToRoute('accueil');
        
    }

}
