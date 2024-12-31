<?php

namespace App\Form;

use App\Entity\Cycle;
use App\Entity\Filiere;
use App\Entity\FiliereCycle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiliereCycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filiere', EntityType::class, [
                'class' => Filiere::class,
                'choice_label' => 'id',
                'label' => 'form.filiere_cycle.filiere'
            ])
            ->add('cycle', EntityType::class, [
                'class' => Cycle::class,
                'choice_label' => 'id',
                'label' => 'form.filiere_cycle.cycle'
            ])
            ->add('fraisInscription', null, [
                'label' => 'form.filiere_cycle.fraisInscription'
            ])
            ->add('montantPension', null, [
                'label' => 'form.filiere_cycle.montantPension'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FiliereCycle::class,
        ]);
    }
}
