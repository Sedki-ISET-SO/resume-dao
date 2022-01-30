<?php

namespace App\Form;

use App\Form\ListingType;
use App\Entity\ListingCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ListingCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                "label" => "Category Name:"
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
            'data_class' => ListingCategory::class,
        ]);
    }
}
