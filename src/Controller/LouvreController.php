<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\Tarifs;
use App\Form\ReservationType;
use App\Services\Prix;
use App\Services\SendMail3;
use App\Services\StripePayment;
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
        $prix_billet = new Prix();

        //création du formulaire
        $form = $this->createForm(ReservationType::class, $reservation);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            //Récupération des prix en fonction de la date de naissance
            $prix_billet->findPrice($reservation);
            if ($request->hasSession() && ($session = $request->getSession())) {
                
                //création de la session $reservation
                $session->set('session_billets', $reservation);
                //$this->addFlash('success', 'Réservation enregistrée'); 
            }

        return $this->redirectToRoute('recapitulatif');
     
        }
        // Création du formulaire de réservation dans le fichier twig
        return $this->render('louvre/reservation.html.twig', [
                    'formReservation' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/recapitulatif", name="recapitulatif")
     */
    public function Recap() {

        $session = new Session();
        $reservation = $session->get('session_billets');                        //vérification de la session
        if($reservation==null){
            $this->addFlash('danger','Vous n\'avez pas accès à cette page');    //Message d'erreur s'il n'y a pas de session
            return $this->redirectToRoute('accueil');                           //Redirection vers la page d'accueil                  
        }
        $billets = $reservation->getBillets();                                  // Récupération des billets
        return $this->render('louvre/recapitulatif.html.twig', [
                    'recap' => $reservation,
                    'billets' => $billets,
        ]);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment(SendMail3 $sendmail, StripePayment $stripe) {

        $session = new Session();
       
        //Récupération de la session
        $reservation = $session->get('session_billets');
        
         if($reservation==null){
            $this->addFlash('danger','Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('accueil');
        }
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
         
        
        // Envoi de la demande de paiement
       $transaction = $stripe->StripePayment($prixTTC,$token);
       
       if ( $transaction->status === 'succeeded' ) {
        // Insertion dans la base de données
        $entityManager->persist($reservation);
        $entityManager->flush();

        //Envoi de la confirmation par mail
        $sendmail->MailConfirmation($reservation, $billets);
        
            $this->addFlash('success','La confirmation de votre réservation a été envoyée');
            return $this->redirectToRoute('succes');
             
        }
        else{
            $this->addFlash('danger','Une erreur de paiement s\'est produite');
            return $this->redirectToRoute('echec');
        }
            
        
    }
    
    /**
     * @Route("/succes", name="succes")
     */
    
    public function succes(){
        
        $session = new Session();
        $session->clear();
        return $this->render('louvre/succes.html.twig');
        
    }
    
     /**
     * @Route("/echec", name="echec")
     */
    
    public function echec(){
        $session = new Session();
        $session->clear();
        return $this->render('louvre/echec.html.twig');
        
    }

}
