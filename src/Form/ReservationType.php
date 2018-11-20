<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
                ->add('nb_billets')
                ->add('mail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
