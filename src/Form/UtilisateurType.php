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
            ->add('nom', null, [
                'label' => 'form.utilisateur.nom'
            ])
            ->add('prenom', null, [
                'label' => 'form.utilisateur.prenom'
            ])
            ->add('email', null, [
                'label' => 'form.utilisateur.email'
            ])
            ->add('motdepasse', null, [
                'label' => 'form.utilisateur.motdepasse'
            ])
            ->add('numerotelephone', null, [
                'label' => 'form.utilisateur.numerotelephone'
            ])
            ->add('cni', null, [
                'label' => 'form.utilisateur.cni'
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
                'label' => 'form.utilisateur.dateNaissance'
            ])
            ->add('lieuNaissance', null, [
                'label' => 'form.utilisateur.lieuNaissance'
            ])
            ->add('sexe', null, [
                'label' => 'form.utilisateur.sexe'
            ])
            ->add('adresse', null, [
                'label' => 'form.utilisateur.adresse'
            ])
            ->add('profession', null, [
                'label' => 'form.utilisateur.profession'
            ])
            ->add('photoProfil', null, [
                'label' => 'form.utilisateur.photoProfil'
            ])
            ->add('dateCreation', null, [
                'widget' => 'single_text',
                'label' => 'form.utilisateur.dateCreation'
            ])
            ->add('dateModification', null, [
                'widget' => 'single_text',
                'label' => 'form.utilisateur.dateModification'
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
