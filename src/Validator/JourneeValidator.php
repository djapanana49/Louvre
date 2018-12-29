<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use DateTime;
use DateTimeZone;


class JourneeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\Journee */
       $heure= new DateTime('now',new DateTimeZone('Europe/Paris'));
        $heure2= new DateTime();
        $heure2->setTime(14,0);
       // var_dump($heure->format('H:i')>$heure2->format('H:i'));die;
        if (($heure->format('H:i')>$heure2->format('H:i')==true) && ($value==true)){

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
            }
    }
}
