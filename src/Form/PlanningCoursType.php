<?php

namespace App\Form;

use App\Entity\PlanningCours;
use App\Entity\SalleCours;
use App\Entity\UE;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningCoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
                'label' => 'form.planning_cours.dateDebut'
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
                'label' => 'form.planning_cours.dateFin'
            ])
            ->add('ue', EntityType::class, [
                'class' => UE::class,
                'choice_label' => 'id',
                'label' => 'form.planning_cours.ue'
            ])
            ->add('salleCours', EntityType::class, [
                'class' => SalleCours::class,
                'choice_label' => 'id',
                'label' => 'form.planning_cours.salleCours'
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'id',
                'label' => 'form.planning_cours.professeur'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanningCours::class,
        ]);
    }
}
