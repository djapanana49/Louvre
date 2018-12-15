<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JoursFermesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\JoursFermes */
        var_dump($value->format('d/m'));
        $jours_feries=new \DateTime();
        $jours_feries->format('d/m');
       $a=array("25/12","01/01","01/05","08/05","14/07","15/08","01/11","11/11");
if (array_key_exists($value->format('d/m'),$a))
  {
   var_dump($a);die;
  $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->format('d/m'))
            ->addViolation();
  }
        

        
        
    }
}
