<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\BilletsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
                ->add('mail')
                ->add('billets', CollectionType::class, array(
        'entry_type'   => BilletsType::class,
        'allow_add'    => true,
        'allow_delete' => true
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
