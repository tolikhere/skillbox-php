<?php

namespace App\Form;

use App\Form\Model\UserRegistrationFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'label.first_name',
                'required' => false,
                'attr' => [
                    'placeholder' => 'placeholder.first_name',
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'placeholder.email'
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
                // 'required' => false
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'label.password',
                'attr' => [
                    'placeholder' => 'placeholder.password'
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
                // 'required' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'label.agree_terms',
                // 'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'value' => 'My button',
                    'class' => 'form-control btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationFormModel::class,
        ]);
    }
}
