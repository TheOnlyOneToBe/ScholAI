<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Incident;
use App\Enum\GraviteIncident;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'form.incident.titre'
            ])
            ->add('description', null, [
                'label' => 'form.incident.description'
            ])
            ->add('dateIncident', null, [
                'widget' => 'single_text',
                'label' => 'form.incident.dateIncident',
                'format' => 'dd MMMM yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'JJ MM AAAA'
                ]
            ])
            ->add('gravite', EnumType::class, [
                'class' => GraviteIncident::class,
                'label' => 'form.incident.gravite',
                'choice_label' => function (GraviteIncident $gravite) {
                    return $gravite->value;
                }
            ])
            ->add('statut', null, [
                'label' => 'form.incident.statut'
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
                'label' => 'form.incident.etudiant'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
