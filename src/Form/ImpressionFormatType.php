<?php

namespace App\Form;

use App\Entity\ImpressionFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImpressionFormatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomFormat', null, [
                'label' => 'form.impression_format.nomFormat'
            ])
            ->add('largeurPage')
            ->add('longueurPage')
            ->add('description', null, [
                'label' => 'form.impression_format.description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImpressionFormat::class,
        ]);
    }
}
