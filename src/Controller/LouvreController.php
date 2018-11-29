<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tarifs;
use App\Entity\Billets;
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
     if ($request->isMethod('POST')) {
    $form->handleRequest($request);
    function findPrice(Tarifs $tarifs, Billets $billets){
        
        $date = new Date($billets->getDateDeNaissance());
        $date2=new Date("now");
        $date->format('d/m/Y');
        $date2->format('d/m/Y');
       $interval=  $date->diff($date2);
       $age= (int)$interval->y;
       if($age >=12){
       $tarifs->type_tarifs("Normal");
       
       }
        else if ($age>=60)
        $tarifs->type_tarifs("Séniors");
        
        else if(($age>=4) &&($age <12))
         $tarifs->type_tarifs("Enfants");   
        
        
    }
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('accueil');
    }
     }
    return $this->render('louvre/reservation.html.twig',[
        'formReservation'=>$form->createView()
    ]);
    // ...
}
}
