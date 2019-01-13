<?php

namespace App\Validator;

use App\Repository\ReservationsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class CheckNbBilletsValidator extends ConstraintValidator
{
    
    /**
     * @var ReservationsRepository
     */
    protected $em;
    
    public function __construct(ReservationsRepository $entityManager)
    {        
        $this->em = $entityManager;
    }

    
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint CheckNbBillets */
        
        if ( $this->em->SumTicket($value)>= 10 ) {
            $this->context->buildViolation($constraint->message)
                    ->atPath('type')
                    ->addViolation();
        }


    }
}
