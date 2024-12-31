<?php

namespace App\Form;

use App\Entity\AnneeAcademique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneeAcademiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('YearStart', null, [
                'widget' => 'single_text',
                'label' => 'form.annee_academique.year_start',
            ])
            ->add('YearEnd', null, [
                'widget' => 'single_text',
                'label' => 'form.annee_academique.year_end',
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnneeAcademique::class,
            'translation_domain' => 'messages'
        ]);
    }
}
