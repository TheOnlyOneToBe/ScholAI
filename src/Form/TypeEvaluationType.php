<?php

namespace App\Form;

use App\Entity\TypeEvaluation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeEvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomType', null, [
                'label' => 'form.type_evaluation.nomType'
            ])
            ->add('description', null, [
                'label' => 'form.type_evaluation.description'
            ])
            ->add('coefficient', null, [
                'label' => 'form.type_evaluation.coefficient'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeEvaluation::class,
        ]);
    }
}
