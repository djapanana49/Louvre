<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tarifs;
use App\Form\ReservationType;
use App\Entity\Reservations;
use Symfony\Component\HttpFoundation\Request;
use DateTimeZone;

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
        $prix=$this->getDoctrine()->getRepository(Tarifs::class)->findAll();
        return $this->render('louvre/accueil.html.twig', array(
            'prix' => $prix)
        );
    }
    
    /**
     * @Route("/reservation", name="reservation")
     */
    public function newReservation(Request $request)
{
    $reservation = new Reservations();
    $reservation->setDateReservation(new \DateTime('now',new DateTimeZone('Europe/Paris')));
    $reservation->setDateVisite(new \DateTime('now',new DateTimeZone('Europe/Paris')));
    $reservation->setNumReservation(uniqid(). time());
    $form = $this->createForm(ReservationType::class, $reservation);
    $form->handleRequest($request);
    return $this->render('louvre/reservation.html.twig',[
        'formReservation'=>$form->createView()
    ]);
    // ...
}
}
