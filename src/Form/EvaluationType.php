<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Programme;
use App\Entity\Semestre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'évaluation',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 3]
            ])
            ->add('dateEvaluation', DateTimeType::class, [
                'label' => 'Date de l\'évaluation',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('programme', EntityType::class, [
                'class' => Programme::class,
                'choice_label' => function(Programme $programme) {
                    return $programme->getMatiere()->getLibelle() . ' - ' . 
                           $programme->getFiliereCycle()->getFiliere()->getLibelle() . ' - ' .
                           $programme->getAnnee()->getLibelle();
                },
                'label' => 'Programme',
                'attr' => ['class' => 'form-control']
            ])
            ->add('semestre', EntityType::class, [
                'class' => Semestre::class,
                'choice_label' => 'libelle',
                'label' => 'Semestre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Contrôle Continu' => 'cc',
                    'Examen' => 'examen',
                    'TP' => 'tp',
                    'Projet' => 'projet'
                ],
                'label' => 'Type d\'évaluation',
                'attr' => ['class' => 'form-control']
            ])
            ->add('coefficient', NumberType::class, [
                'label' => 'Coefficient',
                'attr' => ['class' => 'form-control', 'min' => 0]
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
