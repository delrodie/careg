<?php

namespace App\Form;

use App\Entity\Activite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('nom')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('lieu')
            ->add('situation')
            ->add('description')
            ->add('latittude')
            ->add('longetude')
            ->add('nomProprietaire')
            ->add('fonctionProprietaire')
            ->add('contactProprietaire')
            ->add('autorisation')
            ->add('niveau')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('annee')
            ->add('groupe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
