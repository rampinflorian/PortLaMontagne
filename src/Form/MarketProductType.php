<?php

namespace App\Form;

use App\Entity\MarketProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MarketProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la vente'
            ])
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class, [
                'label' => 'prix'
            ])
            ->add('imageFirst', FileType::class, [
                'mapped' => false,
                'label' => 'Première image',
                'required' => $options['required_image_first'],
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Vous devez uploader une image'
                    ])
                ]
            ])
            ->add('imageSecond', FileType::class, [
                'mapped' => false,
                'label' => 'Seconde image',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
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
            'data_class' => MarketProduct::class,
            'required_image_first' => true
        ]);
    }
}
