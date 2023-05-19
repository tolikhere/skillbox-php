<?php

namespace App\Validator;

use App\Homework\RegistrationSpamFilter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsBotValidator extends ConstraintValidator
{
    public function __construct(
        private RegistrationSpamFilter $registrationSpamFilter
    ) {
    }
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\IsBot $constraint */

        if (!$constraint instanceof IsBot) {
            throw new UnexpectedTypeException($constraint, IsBot::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        if ($this->registrationSpamFilter->filter($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
