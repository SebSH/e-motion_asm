<?php

namespace App\Form;

use App\Entity\Vehicle;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand')
            ->add('model')
            ->add('serial_number')
            ->add('colour')
            ->add('license_plate')
            ->add('mileage')
            ->add('purchase_date', DateType::class, array(
                'format' => 'dd-MM-yyyy',
            ))
            ->add('rental_price')
            ->add('daily_price')
            // ->add('available')
             ->add('id_category', EntityType::class, array(
                 'class' => Category::class,
                 'choice_label' => 'type',
                 'choice_value' => function (Category $category) {
                     return $category->getId();
                 }
             ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
