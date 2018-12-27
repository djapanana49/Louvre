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
   
    $form = $this->createForm(ReservationType::class, $reservation);
     if ($request->isMethod('POST')) {
    $form->handleRequest($request);
    
        
    }
    if ($form->isSubmitted() && $form->isValid()) {
      
        /*$entityManager->persist($reservation);
        $entityManager->flush();*/
    $billets=$reservation->getBillets();
    
     $prix= $prix_billet->findPrice($reservation);
     /*echo'<pre>';
      var_dump($reservation);die;
     echo'</pre>';die;*/
    if ($request->hasSession() && ($session = $request->getSession())) {
    $session->set('session_billets', $reservation);
    $session->getFlashBag()->add('notice', 'Demande de billet(s) envoyée');

}

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
    public function Recap(Request $request)
{
        $reservation = new Reservations();
        $session = new Session();
        $reservation=$session->get('session_billets');
        $billets=$reservation->getBillets();
        $form = $this->createForm(ReservationType::class, $reservation);
        if ($request->isMethod('POST')) {
        $form->handleRequest($request);}
         return $this->render('louvre/recapitulatif.html.twig',[
        'recap'=>$reservation,
        'billets'=>$billets,
        'formReservation'=>$form->createView(),
    ]);
        
}
}
