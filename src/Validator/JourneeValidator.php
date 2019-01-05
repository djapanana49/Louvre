<?php

namespace App\Validator;

use App\Services\CheckJournee;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JourneeValidator extends ConstraintValidator
{
    
    
    public function validate($value, Constraint $constraint)
    {
   // $check = new CheckJournee($reservation);
  $objectResa=$this->context->getObject();
  $check = new CheckJournee($objectResa);
  
  if(($check->CheckJournee()==false)&&($value==true)){
      
      $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}',$value)
            ->addViolation();
  }
        /* @var $constraint Journee */
   
        
   
    }
}
