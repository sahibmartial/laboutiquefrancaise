<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,
                ['disabled'=>true,
                'label'=>'Votre email'
                ])
            ->add('firstname',TextType::class,
                ['disabled'=>true,
                'label'=>'Votre nom'
                ])
            ->add('lastname',TextType::class,
                ['disabled'=>true,
                'label'=>'Votre Prenom'
                ])
          //  ->add('roles')
            ->add('old_password',PasswordType::class,
                ['label'=>'Votre mot de passe actuel',
                'mapped'=>false,
                'attr'=>['placeholder'=>'Votre mot de passe actuel' ]
                ])
//mapped permet add un champ qui ne figure pas ds mo entity 
             ->add('new_password', RepeatedType::class, [
                  'type' => PasswordType::class,
                  'mapped'=>false,
                 'invalid_message' => 'Nouveau mot de pass et Confirmation doivent etre identique',
                 'options' => ['attr' => ['class' => 'password-field']],
                 'required' => true,
                'first_options'  => ['label' => 'New Password',
                'attr'=>['placeholder'=>'Merci de saisir votre nouveau password']],
                'second_options' => ['label' => 'Confirm New Password',
                'attr'=>['placeholder'=>'Merci de confirmer votre nouveau password']],
                ])
              ->add('submit',SubmitType::class,
                ['label'=>"mettre a jour"
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
