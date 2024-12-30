<?php

namespace App\Form;

use App\Entity\AnneeAcademique;
use App\Entity\Etudiant;
use App\Entity\FiliereCycle;
use App\Entity\Inscription;
use App\Entity\Semestre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut')
            ->add('isSuspended')
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
            ])
            ->add('filiereCycle', EntityType::class, [
                'class' => FiliereCycle::class,
                'choice_label' => 'id',
            ])
            ->add('semestre', EntityType::class, [
                'class' => Semestre::class,
                'choice_label' => 'id',
            ])
            ->add('annee', EntityType::class, [
                'class' => AnneeAcademique::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
