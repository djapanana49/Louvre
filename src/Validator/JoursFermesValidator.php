<?php

namespace App\Validator;

use DateInterval;
use DateTime;
use DateTimeZone;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JoursFermesValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint) {
        /* @var $constraint JoursFermes */
        $annee = $value->format('Y');
        $jour = $value->format('d');
        $mois = $value->format('m');
        $jd2 = cal_to_jd(CAL_GREGORIAN, date("$mois"), date("$jour"), date("$annee"));
        $jours = (easter_days($annee));
        $datedeb = new DateTime('21-03-' . $annee);
        $paques = $datedeb->add(new DateInterval('P' . $jours . 'D'));
        $LundiPaques = new Datetime($paques->format('m/d') . '+1 day', new DateTimeZone('Europe/Paris'));
        $ascension = new Datetime($paques->format('m/d') . '+39 day', new DateTimeZone('Europe/Paris'));
        $pentecote = new Datetime($paques->format('m/d') . '+50 day', new DateTimeZone('Europe/Paris'));

        $a = array("25/12", "01/01", "01/05", "08/05", "14/07", "15/08", "01/11", "11/11", $paques->format('d/m'), $LundiPaques->format('d/m'), $ascension->format('d/m'), $pentecote->format('d/m'));



        if ((in_array($value->format('d/m'), $a))) {

            $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value->format('d/m'))
                    ->addViolation();
        } elseif ((jddayofweek($jd2, 0) == 2) || (jddayofweek($jd2, 0) == 0)) {
            $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value->format('d/m'))
                    ->addViolation();
        }
    }

}
