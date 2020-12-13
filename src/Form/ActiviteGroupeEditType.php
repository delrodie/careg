<?php

namespace App\Form;

use App\Entity\Activite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ActiviteGroupeEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,[
                'attr'=>['class'=>'form-control select', 'autocomplete'=>"off"],
                'choices' =>[
                    '-- selectionnez -- ' => '',
                    '' => '',
                    'Initiation' => 'INITIATION',
                    'Progression' => 'PROGRESSION',
                    'Formation' => 'FORMATION',
                    'Loisir' => 'LOISIR',
                    'Autre' => 'AUTRE'
                ]
            ])
            ->add('niveau', ChoiceType::class,[
                'attr'=>['class'=>'form-control select', 'autocomplete'=>"off"],
                'choices' =>[
                    '-- selectionnez -- ' => '',
                    '' => '',
                    'Activité des Chefs' => '13',
                    'Activités de tous les scouts du groupe' => '14'
                ]
            ])
            ->add('nom', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Dénomination du camp", 'autocomplete'=>"off"]])
            ->add('dateDebut', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Date début activité", 'autocomplete'=>"off"]])
            ->add('dateFin', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Date fin activité", 'autocomplete'=>"off"]])
            ->add('lieu', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Lieu de camping", 'autocomplete'=>"off"]])
            ->add('situation', TextareaType::class,[
                'attr'=>['class'=>"form-control", 'rows'=>5],
                'label'=>"Description de la situation géographique du site"
            ])
            ->add('description', TextareaType::class,[
                'attr'=>['class'=>"form-control", 'rows'=>5],
                'label'=>"Presentation de l'activité"
            ])
            ->add('latittude', TextType::class,[
                'attr'=>['class'=>"form-control", 'placholder'=>"La latitude du site", 'autocomplete'=>"off"],
                'required'=>false,
                'label'=>"La latitude du lieu du camp (facultative)"
            ])
            ->add('longetude', TextType::class,[
                'attr'=>['class'=>"form-control", 'placholder'=>"La longititude du site", 'autocomplete'=>"off"],
                'required'=>false,
                'label'=>"La longitude du lieu du camp (facultatiive)"
            ])
            ->add('nomProprietaire', TextType::class,[
                'attr'=>['class'=>"form-control", 'placholder'=>"Nom du propriétaire ou responsable du site", 'autocomplete'=>"off"],
                'label'=>"Nom du propriétaire du site d'accueil"
            ])
            ->add('fonctionProprietaire', TextType::class,[
                'attr'=>['class'=>"form-control", 'placholder'=>"Fonction ou profession du propriétaire", 'autocomplete'=>"off"],
                'label'=>"Fonction ou profession du propriétaire"
            ])
            ->add('contactProprietaire', TextType::class,[
                'attr'=>['class'=>"form-control", 'placholder'=>"Contact téléphonique du propriétaire", 'autocomplete'=>"off"],
                'label'=>"Contact téléphonique de propriétaire"
            ])
            ->add('autorisation', FileType::class,[
                'attr'=>['class'=>''],
                'label' => "Copie de l'autorisation",
                'mapped' => false,
                'multiple' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => "1000000k",
                        'mimeTypes' =>[
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/webp',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image ou document PDF"
                    ])
                ]
            ])
            //->add('createdAt')
            //->add('updatedAt')
            //->add('annee')
            //->add('groupe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
