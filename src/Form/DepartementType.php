<?php

namespace App\Form;

use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomDepartement', null, [
                'attr' => [
                    'label'=>'form.departement.form.name',
                    'placeholder' => 'form.departement.name_placeholder'
                ]
            ])

            ->add('dateCreation', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime',
                'label'=>'form.departement.creation_date',
                'attr' => [
                    'max' => date('Y-m-d\TH:i'),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
            'translation_domain' => 'messages'
        ]);
    }
}
