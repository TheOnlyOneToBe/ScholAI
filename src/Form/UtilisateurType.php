<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Role;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('motdepasse')
            ->add('numerotelephone')
            ->add('cni')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('lieuNaissance')
            ->add('sexe')
            ->add('adresse')
            ->add('profession')
            ->add('photoProfil')
            ->add('dateCreation', null, [
                'widget' => 'single_text',
            ])
            ->add('dateModification', null, [
                'widget' => 'single_text',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'id',
            ])
            ->add('Etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
            ])
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
