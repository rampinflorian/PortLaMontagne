<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control gui-input',
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control gui-input',
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'required' =>false,
                'invalid_message' => 'Les mots de passe ne correspondent pas',

                'options' => [
                    'attr' => [
                        'class' => 'form-control gui-input',
                    ]
                ],
                'first_options' => [
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Confirmer le mot de passe'
                    ]
                ]

            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control gui-input',
                    'placeholder' => 'Description'
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Télécharger une photo de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Vous devez uploader une image'
                    ])
                ]
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
