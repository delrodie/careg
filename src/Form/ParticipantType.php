<?php

namespace App\Form;

use App\Entity\Participant;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->activite =$options['activite'];
        $activite = $this->activite;

        $builder
            ->add('matricule', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Matricule", 'autocomplete'=>"off"]])
            //->add('carte')
            //->add('nom')
            //->add('prenoms')
            //->add('dateNaissance')
            //->add('lieuNaissance')
            //->add('sexe')
            //->add('branche')
            //->add('fonction')
            //->add('contact')
            //->add('urgance')
            //->add('statut')
            //->add('createdBy')
            //->add('groupe')
            /*->add('activite', EntityType::class,[
                'attr'=>['class'=>'form-control'],
                'class'=> 'App:Activite',
                'query_builder'=> function(EntityRepository $er) use($activite){
                    return $er->findActivite($activite);
                }
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'activite' => null
        ]);
    }
}
