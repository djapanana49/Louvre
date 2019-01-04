<?php

namespace App\Validator;

use App\Services\CheckJournee;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JourneeValidator extends ConstraintValidator
{
    
    
    public function validate($reservation, Constraint $constraint)
    {
    $check = new CheckJournee($reservation);
        /* @var $constraint Journee */
   if($check->CheckJournee()==false){
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}',$reservation)
            ->addViolation();
   }
    }
}
