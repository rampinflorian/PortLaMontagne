<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'gui-input',
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'gui-textarea summernote',
                    'placeholder' => 'Contenu'
                ]

            ])
            ->add('image', FileType::class, [
                'label' => 'Image de couverture',
                'mapped' => false,
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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $categoryRepository) {
                    return $categoryRepository->QueryBuilderFindAll();
                },
                'choice_label' => function ($category) {
                    return $category->getTitle();
                },
                'attr' => [
                    'class' => 'field select'
                ]
            ])
            ->add('isAlert', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Cet article est une alerte',
                'attr' => [
                    'class' => 'checkbox'
                ]
            ])
            ->add('alert', AlertType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
