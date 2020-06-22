<?php

namespace App\Form;

use App\Entity\ClimbingGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClimbingGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('dificultyMin')
            ->add('dificultyMax')
            ->add('createdAt')
            ->add('releaseAt')
            ->add('isOpen')
            ->add('maxClimber')
            ->add('isRegistrationOpened')
            ->add('area')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClimbingGroup::class,
        ]);
    }
}
