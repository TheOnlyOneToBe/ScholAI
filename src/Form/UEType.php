<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Professeur;
use App\Entity\Semestre;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('volumeHoraire', null, [
                'label' => 'form.ue.volumeHoraire'
            ])
            ->add('statut', null, [
                'label' => 'form.ue.statut'
            ])
            ->add('matiere', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'id',
                'label' => 'form.ue.matiere'
            ])
            ->add('profeseur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'id',
                'label' => 'form.ue.profeseur'
            ])
            ->add('semestre', EntityType::class, [
                'class' => Semestre::class,
                'choice_label' => 'id',
                'label' => 'form.ue.semestre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UE::class,
        ]);
    }
}
