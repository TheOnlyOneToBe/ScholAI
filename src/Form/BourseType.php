<?php

namespace App\Form;

use App\Entity\Bourse;
use App\Entity\Etudiant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', null, [
                'label' => 'form.bourse.montant'
            ])
            ->add('description', null, [
                'label' => 'form.bourse.description'
            ])
            ->add('dateLimite', null, [
                'label' => 'form.bourse.dateLimite'
            ])
            ->add('statut', null, [
                'label' => 'form.bourse.statut'
            ])
            ->add('remise')
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bourse::class,
        ]);
    }
}
