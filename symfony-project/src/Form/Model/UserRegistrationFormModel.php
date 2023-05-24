<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AppAssert;

class UserRegistrationFormModel
{
    #[Assert\Email(message: 'user.email')]
    #[Assert\NotBlank(message: 'user.blank_email')]
    #[appAssert\UniqueUser(message: 'user.unique_email')]
    #[AppAssert\IsBot(message: 'user.is_bot')]
    public ?string $email;

    public ?string $firstName;

    #[Assert\NotBlank(message: 'user.blank_password')]
    #[Assert\Length(min: 6, minMessage: 'user.too_short_password')]
    public ?string $plainPassword;

    #[Assert\IsTrue(message: 'user.is_true_agree_terms')]
    public ?string $agreeTerms;
}
