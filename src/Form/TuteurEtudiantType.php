<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\TuteurEtudiant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TuteurEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'form.tuteur_etudiant.nom'
            ])
            ->add('prenom', null, [
                'label' => 'form.tuteur_etudiant.prenom'
            ])
            ->add('sexe', null, [
                'label' => 'form.tuteur_etudiant.sexe'
            ])
            ->add('numTelephone', null, [
                'label' => 'form.tuteur_etudiant.numTelephone'
            ])
            ->add('typeTuteur', null, [
                'label' => 'form.tuteur_etudiant.typeTuteur'
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
                'label' => 'form.tuteur_etudiant.etudiant'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TuteurEtudiant::class,
        ]);
    }
}
