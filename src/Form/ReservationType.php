<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Form\BilletsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('num_reservation', HiddenType::class)
                ->add('date_visite',DateTimeType::class, array(
                    'format'=> 'dd/MM/yyyy',
                    'widget' => 'single_text',
                ))
               /* ->add('date_reservation',DateTimeType::class, array(
                    'format'=> 'dd/MM/yyyy',
                    'widget' => 'single_text',))*/
                ->add('nb_billets',IntegerType::class,array(
                        'data' => '1',
                ))
                ->add('journee',ChoiceType::class, array(
                    'choices' => array(
                        'Journée'=>true,
                        'Demi-journée'=>false),
                    'expanded' => true,
                    ))
                ->add('billets', CollectionType::class, array(
                    'entry_type'   => BilletsType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    
                ))
               ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
