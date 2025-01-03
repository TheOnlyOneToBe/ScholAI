<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCours', TextType::class, [
                'label' => 'form.cours.nomCours',
                'attr' => [
                    'placeholder' => 'form.cours.nomCours.placeholder'
                ]
            ])
            ->add('typeCours', ChoiceType::class, [
                'label' => 'form.cours.typeCours',
                'choices' => [
                    'form.cours.typeCours.cm' => 'CM',
                    'form.cours.typeCours.td' => 'TD',
                    'form.cours.typeCours.tp' => 'TP'
                ],
                'placeholder' => 'form.cours.typeCours.placeholder',
                'required' => true
            ])
            ->add('descriptif', TextareaType::class, [
                'label' => 'form.cours.descriptif',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'form.cours.descriptif.placeholder'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
