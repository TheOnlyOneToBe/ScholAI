<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('noms')
            ->add('prenoms')
            ->add('age')
            ->add('telephone')
            ->add('adresseStudent')
            ->add('photo')
            ->add('sexeEtudiant')
            ->add('matriculeStudent')
            ->add('studentFather')
            ->add('studentMother')
            ->add('father_number')
            ->add('mother_number')
            ->add('studentEmail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
