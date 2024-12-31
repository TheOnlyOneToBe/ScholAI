<?php

namespace App\Form;

use App\Entity\AntecedentAcademique;
use App\Entity\Etudiant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AntecedentAcademiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etablissement', null, [
                'label' => 'form.antecedent_academique.etablissement'
            ])
            ->add('diplome', null, [
                'label' => 'form.antecedent_academique.diplome'
            ])
            ->add('matriculeDiplome')
            ->add('anneeObtention', null, [
                'label' => 'form.antecedent_academique.anneeObtention',
                'widget' => 'single_text',
            ])
            ->add('moyenne', null, [
                'label' => 'form.antecedent_academique.moyenne'
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
                'label' => 'form.antecedent_academique.etudiant'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AntecedentAcademique::class,
        ]);
    }
}
