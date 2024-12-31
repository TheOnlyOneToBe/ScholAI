<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\PlanningCours;
use App\Entity\Presence;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datePresence', null, [
                'widget' => 'single_text',
                'label' => 'form.presence.datePresence'
            ])
            ->add('statut', null, [
                'label' => 'form.presence.statut'
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
                'label' => 'form.presence.etudiant'
            ])
            ->add('planningCours', EntityType::class, [
                'class' => PlanningCours::class,
                'choice_label' => 'id',
                'label' => 'form.presence.planningCours'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presence::class,
        ]);
    }
}
