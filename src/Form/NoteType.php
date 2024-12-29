<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use App\Entity\Programme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('evaluation', EntityType::class, [
                'class' => Evaluation::class,
                'choice_label' => 'titre',
                'label' => 'Évaluation',
                'attr' => ['class' => 'form-control']
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => function(Etudiant $etudiant) {
                    return $etudiant->getMatriculeStudent() . ' - ' . 
                           $etudiant->getNoms() . ' ' . $etudiant->getPrenoms();
                },
                'label' => 'Étudiant',
                'attr' => ['class' => 'form-control']
            ])
            ->add('programme', EntityType::class, [
                'class' => Programme::class,
                'choice_label' => function(Programme $programme) {
                    return $programme->getMatiere()->getLibelle() . ' - ' . 
                           $programme->getFiliereCycle()->getFiliere()->getLibelle();
                },
                'label' => 'Programme',
                'attr' => ['class' => 'form-control']
            ])
            ->add('valeur', NumberType::class, [
                'label' => 'Note',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.25
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 2]
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'en_attente',
                    'Validée' => 'validee',
                    'En révision' => 'en_revision'
                ],
                'label' => 'Statut',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
