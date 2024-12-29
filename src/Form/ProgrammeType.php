<?php

namespace App\Form;

use App\Entity\Annee;
use App\Entity\FiliereCycle;
use App\Entity\Matiere;
use App\Entity\Professeur;
use App\Entity\Programme;
use App\Entity\Semestre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heurealloue')
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'id',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'id',
            ])
            ->add('FiliereCycle', EntityType::class, [
                'class' => FiliereCycle::class,
                'choice_label' => 'id',
            ])
            ->add('annee', EntityType::class, [
                'class' => Annee::class,
                'choice_label' => 'id',
            ])
            ->add('semestre', EntityType::class, [
                'class' => Semestre::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
