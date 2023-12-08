<?php

namespace App\Form;

use App\Entity\Restau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RestauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('log')
            ->add('lat')
            ->add('client_id',HiddenType::class,[
                'mapped' => false, // If you don't want to map it to an entity property
                // Add other options as needed
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restau::class,
        ]);
    }
}
