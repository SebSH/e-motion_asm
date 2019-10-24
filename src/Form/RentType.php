<?php

namespace App\Form;

use App\Entity\Rent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = range(date('Y'), date('Y') + 1);

        $builder
            ->add('start_date', DateType::class, [
                'years'        => $years,
                
            ])
            ->add('end_date', DateType::class, [
                'years'        => $years,
                
            ])
            // ->add('price')
            // ->add('duration')
            // ->add('mileage')
            // ->add('id_user')
            // ->add('id_vehicle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rent::class,
        ]);
    }
}
