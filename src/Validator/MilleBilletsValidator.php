<?php

namespace App\Validator;

use App\Entity\Reservations;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MilleBilletsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint MilleBillets */
      $objectResa=$this->context->getObject();
      $NbBillets = $this->getDoctrine()
                    ->getRepository(Reservations::class)
                    ->SumTicket($objectResa->getDateVisite());
            if ($NbBillets < 10) {

                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value)
                    ->addViolation();
        }
    }
}
