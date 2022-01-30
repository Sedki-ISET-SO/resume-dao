<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                "label" => "Candidate First Name",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please Enter Your First Name',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your First Name Should Be At Least {{ limit }} Characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 8,
                    ]),
                ],
            ])
            ->add('lastname', null, [
                "label" => "Candidate Last Name",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please Enter Your Last Name',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your last Name Should Be At Least {{ limit }} Characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 8,
                    ]),
                ],
            ])
            ->add('companyname', null, [
                "label" => "Company Name",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please Enter Your Company Name',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your Company Name Should Be At Least {{ limit }} Characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('email', null, [
                "label" => "Professional Email"
            ])
            ->add('agreeTerms', CheckboxType::class, [
                "label" => "Agree To Our Terms",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You Should Agree To Our Terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
