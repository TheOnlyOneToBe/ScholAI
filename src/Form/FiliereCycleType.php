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
            ->add('description')
            ->add('fraisInscription')
            ->add('montantPension')
            ->add('filiere', EntityType::class, [
                'class' => Filiere::class,
                'choice_label' => 'id',
            ])
            ->add('Cycle', EntityType::class, [
                'class' => Cycle::class,
                'choice_label' => 'id',
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
