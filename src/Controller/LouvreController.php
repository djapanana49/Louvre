<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\Tarifs;
use App\Entity\Billets;
use App\Form\ReservationType;
use App\Services\Prix;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;


class LouvreController extends AbstractController
{
    /**
     * @Route("/louvre", name="louvre")
     */
    public function index()
    {
        return $this->render('louvre/index.html.twig', [
            'controller_name' => 'LouvreController',
        ]);
    }
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        $prix=new Tarifs();
        $prix=$this->getDoctrine()->getRepository(Tarifs::class)->findAll();
        return $this->render('louvre/accueil.html.twig', array(
            'prix' => $prix)
        );
    }
    
    /**
     * @Route("/reservation", name="reservation")
     */
    public function newReservation(Request $request, Prix $prix_billet)
{
    
    $reservation = new Reservations();
    $session = new Session();
    $entityManager = $this->getDoctrine()->getManager();
   
    $form = $this->createForm(ReservationType::class, $reservation);
     if ($request->isMethod('POST')) {
    $form->handleRequest($request);
    
        
    }
    if ($form->isSubmitted() && $form->isValid()) {
      
        
        $billets=$reservation->getBillets();
        $prix= $prix_billet->findPrice($reservation);
        if ($request->hasSession() && ($session = $request->getSession())) {
            $session->set('session_billets', $reservation);
        }
        $entityManager->persist($reservation); 
        return $this->redirectToRoute('recapitulatif');
        }
     
        return $this->render('louvre/reservation.html.twig',[
        'formReservation'=>$form->createView(),
        ]);
    // ...
}

/**
     * @Route("/recapitulatif", name="recapitulatif")
     */
    public function Recap(Request $request) {
        $reservation = new Reservations();
        $session = new Session();
        $reservation=$session->get('session_billets');
        $billets=$reservation->getBillets();
         return $this->render('louvre/recapitulatif.html.twig',[
        'recap'=>$reservation,
        'billets'=>$billets,  
    ]);
        
}
    
    /**
     * @Route("/payment", name="payment")
     */
    public function payment(Request $request) { 
       
        $session = new Session();
        $reservation = new Reservations();
        $reservation=$session->get('session_billets');
        $reservation->setMail($_POST['email']);
        $entityManager = $this->getDoctrine()->getManager();
   
    $form = $this->createForm(ReservationType::class, $reservation);
     if ($request->isMethod('POST')) {
    $form->handleRequest($request);
        
    }
    
        
        
        // Recupérer le montant TTC pour le mettre dans le paiement stripe        
        $prixTTC = $_POST['total'];
        $prixTTC = $prixTTC*100; 
        
        $token = $_POST['stripeToken'];
       
        \Stripe\Stripe::setApiKey("sk_test_NMS8iaVWh2STD5FqTP9PCeZz");


        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        
        $charge = \Stripe\Charge::create([
            'amount' => $prixTTC,
            'currency' => 'eur',
            'description' => 'Paiement final',
            'source' => $token,
            'receipt_email'=>'djapanana@free.fr',
        ]);
        if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($reservation);
        $entityManager->flush();
        }
    
    return $this->redirectToRoute('accueil');
}
}