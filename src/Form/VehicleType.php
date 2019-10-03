<?php
namespace App\Form;
use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', null, [
                'required' => true,
                'label' => 'brand*'
            ])
            ->add('model', null, [
                'required' => true,
                'label' => 'model*'
            ])
            ->add('colour', null, [
                'required' => true,
                'label' => 'colour'
            ])
            ->add('serial_number', TelType::class, [
                'required' => true,
                'label' => 'Numéro de serie*'
            ])
            ->add('license_plate', null, [
                'required' => true,
                'label' => 'Numéro de matricule*',
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'max' => 9
                    ])
                ]
            ])
            ->add('mileage', null, [
                'required' => true,
                'label' => 'kilometrage*'
            ])
            ->add('purchase_date', DateType::class, [
                'required' => false,
                'label' => 'date d\'achate du vehicle',
                'years' => range(2016,2019)
            ])
            ->add('rental_price', null, [
                'required' => true,
                'label' => 'prix de location*',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 3
                    ])
                ]
            ])
            ->add('daily_price', null, [
                'required' => true,
                'label' => 'prix de location*',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 2
                    ])
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
