<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneeAcademiqueNoEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('YearStart', DateType::class, [
                'widget' => 'single_text',
                'label' => 'form.annee_academique.year_start',
                'html5' => false,
            ])
            ->add('YearEnd', DateType::class, [
                'widget' => 'single_text',
                'label' => 'form.annee_academique.year_end',
                'html5' => false,
    
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'translation_domain' => 'messages'
        ]);
    }
}
