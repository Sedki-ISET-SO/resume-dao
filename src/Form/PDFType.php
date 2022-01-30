<?php

namespace App\Form;

use App\Entity\PDF;
use App\Form\ListingPictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PDFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('files', CollectionType::class, [
            'entry_type' => ListingPictureType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'required' => false,
            'label'=>false,
            'by_reference' => false,
            'disabled' => false,
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
            'data_class' => PDF::class,
        ]);
    }
}
