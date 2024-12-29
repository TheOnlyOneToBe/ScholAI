<?php

namespace App\Form;

use App\Entity\Annee;
use App\Entity\Etudiant;
use App\Entity\FiliereCycle;
use App\Entity\Inscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ])
            ->add('statutInscription')
            ->add('filierecycle', EntityType::class, [
                'class' => FiliereCycle::class,
                'choice_label' => 'id',
            ])
            ->add('annee', EntityType::class, [
                'class' => Annee::class,
                'choice_label' => 'id',
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
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
