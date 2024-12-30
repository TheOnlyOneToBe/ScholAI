<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Semestre;
use App\Entity\TypeEvaluation;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('tempsEvaluation')
            ->add('statut')
            ->add('UE', EntityType::class, [
                'class' => UE::class,
                'choice_label' => 'id',
            ])
            ->add('semestre', EntityType::class, [
                'class' => Semestre::class,
                'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => TypeEvaluation::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
