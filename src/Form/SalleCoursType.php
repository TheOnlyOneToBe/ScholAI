<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\SalleCours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleCoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSalle', null, [
                'label' => 'form.salle_cours.nomSalle'
            ])
            ->add('capacite', null, [
                'label' => 'form.salle_cours.capacite'
            ])
            ->add('description', null, [
                'label' => 'form.salle_cours.description'
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'id',
                'label' => 'form.salle_cours.campus'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SalleCours::class,
        ]);
    }
}
