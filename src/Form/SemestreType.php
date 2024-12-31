<?php

namespace App\Form;

use App\Entity\AnneeAcademique;
use App\Entity\Semestre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SemestreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSemestre', null, [
                'label' => 'form.semestre.numSemestre'
            ])
            ->add('date_debut', null, [
                'widget' => 'single_text',
                'label' => 'form.semestre.date_debut'
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
                'label' => 'form.semestre.dateFin'
            ])
            ->add('anneeacademique', EntityType::class, [
                'class' => AnneeAcademique::class,
                'choice_label' => 'id',
                'label' => 'form.semestre.anneeacademique'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Semestre::class,
        ]);
    }
}
