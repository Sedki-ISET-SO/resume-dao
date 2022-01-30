<?php

namespace App\Form;

use App\Entity\ListingAvailability;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('availableFrom', null, [
                "label" => "Listing Availability Start Date:"
            ])
            ->add('availableUntil', null, [
                "label" => "Listing Availability Ending Date:"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListingAvailability::class,
        ]);
    }
}
