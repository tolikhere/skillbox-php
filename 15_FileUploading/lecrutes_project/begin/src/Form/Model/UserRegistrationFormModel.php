<?php

namespace App\Form\Model;


use App\Validator\UniqueUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Вы не указали email")
     * @Assert\Email()
     * @UniqueUser()
     */
    public $email;
    
    public $firstName;

    /**
     * @Assert\NotBlank(message="Пароль не указан")
     * @Assert\Length(min=6,minMessage="Пароль должен быть длиной не менее 6-ти символов")
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(message="Вы должны согласиться с условиями")
     */
    public $agreeTerms;
}
