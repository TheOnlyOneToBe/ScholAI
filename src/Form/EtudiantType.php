<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\FiliereCycle;
use App\Entity\Inscription;
use App\Entity\Annee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Doctrine\ORM\EntityManagerInterface;

class EtudiantType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupérer l'année active
        $anneeActive = $this->entityManager->getRepository(Annee::class)->findOneBy(['yearStatut' => true]);

        $builder
            ->add('noms', TextType::class, [
                'label' => 'student.form.fields.noms',
                'attr' => [
                    'placeholder' => 'student.form.placeholders.noms'
                ]
            ])
            ->add('prenoms', TextType::class, [
                'label' => 'student.form.fields.prenoms',
                'attr' => [
                    'placeholder' => 'student.form.placeholders.prenoms'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'student.form.fields.date_naissance',
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('age', IntegerType::class, [
                'label' => 'student.form.fields.age',
                'attr' => [
                    'min' => 15,
                    'max' => 50,
                    'placeholder' => 'student.form.placeholders.age'
                ]
            ])
            ->add('sexeEtudiant', ChoiceType::class, [
                'label' => 'student.form.fields.sexe',
                'choices' => [
                    'student.form.choices.sexe.male' => 'M',
                    'student.form.choices.sexe.female' => 'F'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank(['message' => 'student.form.validation.required'])
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'student.form.fields.telephone',
                'constraints' => [
                    new NotBlank(['message' => 'student.form.validation.required']),
                    new Length([
                        'min' => 8,
                        'max' => 15,
                        'minMessage' => 'student.form.validation.min_length',
                        'maxMessage' => 'student.form.validation.max_length'
                    ])
                ],
                'attr' => ['placeholder' => 'student.form.placeholders.telephone']
            ])
            ->add('adresseStudent', TextType::class, [
                'label' => 'student.form.fields.adresse',
                'required' => false,
                'attr' => ['placeholder' => 'student.form.placeholders.adresse']
            ])
            ->add('photo', FileType::class, [
                'label' => 'student.form.fields.photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'maxSizeMessage' => 'student.form.validation.photo.max_size',
                        'mimeTypesMessage' => 'student.form.validation.photo.mime_types',
                    ])
                ],
                'attr' => ['accept' => 'image/*']
            ])
            ->add('matriculeStudent', TextType::class, [
                'label' => 'student.form.fields.matricule',
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 20,
                        'minMessage' => 'student.form.validation.min_length',
                        'maxMessage' => 'student.form.validation.max_length'
                    ])
                ],
                'attr' => ['placeholder' => 'student.form.placeholders.matricule']
            ])
            ->add('studentEmail', EmailType::class, [
                'label' => 'student.form.fields.email',
                'constraints' => [
                    new NotBlank(['message' => 'student.form.validation.required']),
                    new Email(['message' => 'student.form.validation.email'])
                ],
                'attr' => ['placeholder' => 'student.form.placeholders.email']
            ])
            ->add('studentFather', TextType::class, [
                'label' => 'student.form.fields.father_name',
                'required' => false,
                'attr' => ['placeholder' => 'student.form.placeholders.father_name']
            ])
            ->add('studentMother', TextType::class, [
                'label' => 'student.form.fields.mother_name',
                'required' => false,
                'attr' => ['placeholder' => 'student.form.placeholders.mother_name']
            ])
            ->add('father_number', TelType::class, [
                'label' => 'student.form.fields.father_phone',
                'required' => false,
                'attr' => ['placeholder' => 'student.form.placeholders.father_phone']
            ])
            ->add('mother_number', TelType::class, [
                'label' => 'student.form.fields.mother_phone',
                'required' => false,
                'attr' => ['placeholder' => 'student.form.placeholders.mother_phone']
            ])
            ->add('filiereCycle', EntityType::class, [
                'class' => FiliereCycle::class,
                'choice_label' => function(FiliereCycle $filiereCycle) {
                    return $filiereCycle->getFiliere()->getLibellefiliere() . ' - ' . $filiereCycle->getCycle()->getLibelle();
                },
                'label' => 'student.form.fields.filiere_cycle',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'student.form.validation.required'])
                ],
                'placeholder' => 'student.form.placeholders.filiere_cycle',
                'attr' => [
                    'class' => 'select2'
                ]
            ])
        ;

        if ($anneeActive) {
            $builder->setAttribute('annee_active', $anneeActive);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
            'translation_domain' => 'messages'
        ]);
    }
}
