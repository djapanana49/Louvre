<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use DateInterval;

class JoursFermesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\JoursFermes */
       $annee_actuelle=$value->format('Y');
       $interval = new DateInterval('P38D');
       $interval2 = new DateInterval('P11D');
       $jours=(easter_days($annee_actuelle));
       $datedeb = new \DateTime($annee_actuelle.'-03-21');
       $paques = $datedeb;
       $paques = $paques->add(new DateInterval('P'.$jours.'D'));
       $LundiPaques=$paques;
       $LundiPaques=$LundiPaques->add(new DateInterval('P1D'));
       $ascension=$paques;
       $ascension=$ascension->add($interval);
       $pentecote=$paques;
       $pentecote=$pentecote->add($interval2);
       
       
        
        
        

       $a=array("25/12","01/01","01/05","08/05","14/07","15/08","01/11","11/11",$paques->format('d/m'),$LundiPaques->format('d/m'),$ascension->format('d/m'),$pentecote->format('d/m'));
       var_dump($a);
       $jd2=cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));

echo(jddayofweek($jd2,0));
       die;
if (in_array($value->format('d/m'),$a))
  {
   
  $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->format('d/m'))
            ->addViolation();
  }
        

        
        
    }
}
