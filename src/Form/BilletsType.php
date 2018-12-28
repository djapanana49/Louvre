<?php

namespace App\Form;

use App\Entity\Billets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('date_de_naissance',DateTimeType::class, array(
                    'format'=> 'dd/MM/yyyy',
                    'widget' => 'single_text',
                    'attr' => array(
                        'placeholder'=> 'JJ/MM/AAAA',)
                ))
            ->add('Pays',TextType::class)
            ->add('tarif', HiddenType::class)
            ->add('reduit', CheckboxType::class, array(
                    'label'    => 'Bénéficiez-vous d\'une réduction ?',
                    'required' => false,
                     'value' => true,))
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billets::class,
        ]);
    }
}
