<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LengthValidator;
use Symfony\Component\Validator\Constraints as Assert;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,
                ['label'=>'Nom de votre addresse',
                'constraints'=> new Length(['min' => 2,'max' =>30]),
                'attr'=>
                ['placeholder'=>'Nommez votre addresse']
                ])
            ->add('firstname',TextType::class,
                ['label'=>'Votre prenom',
                'constraints'=> new Length(['min' => 2,'max' =>30]),
                'attr'=>
                ['placeholder'=>'Merci de saisir votre prenom']
                ])
            ->add('lastname',TextType::class,
                ['label'=>'Votre nom',
                'constraints'=> new Length(['min' => 2,'max' =>30]),
                'attr'=>
                ['placeholder'=>'Merci de saisir votre nom']
                ])
            ->add('company',TextType::class,
                ['label'=>'Votre societe',
                'attr'=>
                ['placeholder'=>'(facultatif) Merci de saisir votre compagnie']
                ])
            ->add('address',TextType::class,
                ['label'=>'Votre Addresse',
                'constraints'=> new Length(['min' => 2,'max' =>90]),
                'attr'=>
                ['placeholder'=>'8 rue lafontaine ....']
                ])
            ->add('postal',TextType::class,
                ['label'=>'Votre code Postale',
                'constraints'=> new Length(['min' => 2,'max' =>30]),
                'attr'=>
                ['placeholder'=>'Merci de saisir votre code postale']
                ])
            ->add('city',TextType::class,
                ['label'=>'Votre ville',
                'constraints'=> new Length(['min' => 2,'max' =>30]),
                'attr'=>
                ['placeholder'=>'Merci de saisir votre ville']
                ])
            ->add('country',CountryType::class,
                ['label'=>'Votre pays',
                'attr'=>
                ['placeholder'=>'Merci de saisir votre pays']
                ])
            ->add('phone',TelType::class,
                ['label'=>'Votre Phone',
                'constraints'=> new Length(['min' => 2,'max' =>30]),
                'attr'=>
                ['placeholder'=>'Merci de saisir votre phone']
                ])
            ->add('submit',SubmitType::class,
                ['label'=>"Ajouer Une addresse",
                    'attr'=>['class'=>'btn-block btn-info']
                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
