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
            ->add('annee', null, [
                'label' => 'form.annee_academique.annee'
            ])
            ->add('dateDebut', null, [
                'widget' => 'single_text',
                'label' => 'form.annee_academique.dateDebut'
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
                'label' => 'form.annee_academique.dateFin'
            ])
            ->add('statut', null, [
                'label' => 'form.annee_academique.statut'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnneeAcademique::class,
        ]);
    }
}
