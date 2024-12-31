<?php

namespace App\Form;

use App\Entity\ChefDepartement;
use App\Entity\Departement;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChefDepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
                'label' => 'form.chef_departement.dateDebut'
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
                'label' => 'form.chef_departement.dateFin'
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'id',
                'label' => 'form.chef_departement.professeur'
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'id',
                'label' => 'form.chef_departement.departement'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChefDepartement::class,
        ]);
    }
}
