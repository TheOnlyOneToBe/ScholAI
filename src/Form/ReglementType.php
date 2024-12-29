<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\PayementMethod;
use App\Entity\PayementReason;
use App\Entity\Reglement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReglementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ontantReglement')
            ->add('dateReglement', null, [
                'widget' => 'single_text',
            ])
            ->add('PayementMethod', EntityType::class, [
                'class' => PayementMethod::class,
                'choice_label' => 'id',
            ])
            ->add('payementReason', EntityType::class, [
                'class' => PayementReason::class,
                'choice_label' => 'id',
            ])
            ->add('inscription', EntityType::class, [
                'class' => Inscription::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reglement::class,
        ]);
    }
}
