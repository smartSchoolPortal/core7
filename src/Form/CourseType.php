<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('department')
            ->add('yearOffered')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void //konf manager für Form
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
