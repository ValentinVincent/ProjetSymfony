<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            // ->add('type', ChoiceType::class, [
            //     'choices' => [
            //         'Livret A' => 'Livret A',
            //         'Livret Jeune' => 'Livret Jeune',
            //         'Compte Courant' => 'Compte Courant',
            //         'Compte Joint' => 'Compte Joint',
            //     ]
            // ])
            // ->add('age', EntityType::class, [
            //     'class' => Person::class,
            //     'choice_label' => 'lastname'
            // ])
            ->add('age')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}