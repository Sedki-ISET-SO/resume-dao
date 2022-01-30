<?php

namespace App\Form;

use App\Entity\Resume;
use App\Form\SkillType;
use App\Form\EducationType;
use App\Form\WorkExperienceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('skills', CollectionType::class, [
            'entry_type' => SkillType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'required' => true,
            'label' => false
        ])
        ->add('workExperiences', CollectionType::class, [
            'entry_type' => WorkExperienceType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'required' => true,
            'label' => false
        ])
        ->add('educations', CollectionType::class, [
            'entry_type' => EducationType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'required' => true,
            'label' => false
        ])
        ->add('enregistrer', SubmitType::class, [
            "attr" => ["class" => "bg-danger text-white"],
            'row_attr' => ['class' => 'text-center']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resume::class,
        ]);
    }
}
