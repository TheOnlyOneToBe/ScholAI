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
            ->add('sexe')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('adresse')
            ->add('isRegistrationAllowed')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('numTelephone')
            ->add('lieuNaissance')
            ->add('nationalite')
            ->add('studentPhoto')
            ->add('cni')
            ->add('dateCreation', null, [
                'widget' => 'single_text',
            ])
            ->add('dateModification', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
