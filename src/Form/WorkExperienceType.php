<?php

namespace App\Form;

use App\Entity\WorkExperience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class WorkExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', null, [
                "label" => "Your Role At The Company"
            ])
            ->add('company', null, [
                "label" => "Company You Have Worked For"
            ])
            ->add('start',  null, [
                "label" => "Job Position Starting Date",
            ])
            ->add('end',  null, [
                "label" => "Job Position Ending Date",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkExperience::class,
        ]);
    }
}
