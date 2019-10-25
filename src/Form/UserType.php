<?php
namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                'required' => true,
                'label' => 'Prénom*'
            ])
            ->add('lastname', null, [
                'required' => true,
                'label' => 'Nom*'
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email*'
            ])
            ->add('birthday', DateType::class, [
                'required' => true,
                'label' => 'Date de naissance',
                'years' => range(1919,2019)
            ])
            ->add('address', null, [
                'required' => true,
                'label' => 'Adresse*'
            ])
            ->add('phone_number', TelType::class, [
                'required' => true,
                'label' => 'Numéro de téléphone*'
            ])
            ->add('license_number', null, [
                'required' => true,
                'label' => 'Numéro de license du permis de conduire*',
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'max' => 9
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType:: class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'You have to write an password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password must contain  {{ limit }} character',
                        'max' => 4096,
                    ]),
                ],
                'first_options' => array('label' => 'Password* : '),
                'second_options' => array('label' => 'Confirmation Password* : '),)
            );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}