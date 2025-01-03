<?php

namespace App\Form;

use App\Entity\Payementreason;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayementreasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonPaiement', null, [
                'label' => 'form.payementreason.raisonPaiement'
            ])
            ->add('description', null, [
                'label' => 'form.payementreason.description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payementreason::class,
        ]);
    }
}
