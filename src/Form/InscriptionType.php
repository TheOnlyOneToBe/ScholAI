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
            ->add('statut', null, [
                'label' => 'form.inscription.statut'
            ])
            ->add('isSuspended', null, [
                'label' => 'form.inscription.isSuspended'
            ])
            ->add('dateInscription', null, [
                'widget' => 'single_text',
                'label' => 'form.inscription.dateInscription'
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
                'label' => 'form.inscription.etudiant'
            ])
            ->add('filiereCycle', EntityType::class, [
                'class' => FiliereCycle::class,
                'choice_label' => 'id',
                'label' => 'form.inscription.filiereCycle'
            ])
            ->add('semestre', EntityType::class, [
                'class' => Semestre::class,
                'choice_label' => 'id',
                'label' => 'form.inscription.semestre'
            ])
            ->add('annee', EntityType::class, [
                'class' => AnneeAcademique::class,
                'choice_label' => 'id',
                'label' => 'form.inscription.annee'
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
