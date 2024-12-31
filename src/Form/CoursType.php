<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCours', null, [
                'label' => 'form.cours.nomCours'
            ])
            ->add('code', null, [
                'label' => 'form.cours.code'
            ])
            ->add('description', null, [
                'label' => 'form.cours.description'
            ])
            ->add('credit', null, [
                'label' => 'form.cours.credit'
            ])
            ->add('volumeHoraire', null, [
                'label' => 'form.cours.volumeHoraire'
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
