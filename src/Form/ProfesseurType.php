<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'form.professeur.nom'
            ])
            ->add('prenom', null, [
                'label' => 'form.professeur.prenom'
            ])
            ->add('email', null, [
                'label' => 'form.professeur.email'
            ])
            ->add('numeroTelephone', null, [
                'label' => 'form.professeur.numeroTelephone'
            ])
            ->add('cni', null, [
                'label' => 'form.professeur.cni'
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
                'label' => 'form.professeur.dateNaissance'
            ])
            ->add('nationalite', null, [
                'label' => 'form.professeur.nationalite'
            ])
            ->add('sexe', null, [
                'label' => 'form.professeur.sexe'
            ])
            ->add('adresse', null, [
                'label' => 'form.professeur.adresse'
            ])
            ->add('photoProfil', null, [
                'label' => 'form.professeur.photoProfil'
            ])
            ->add('dateCreation', null, [
                'widget' => 'single_text',
            ])
            ->add('dateModification', null, [
                'widget' => 'single_text',
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
