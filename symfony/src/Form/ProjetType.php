<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Matiere;
use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('nbMax')
            ->add('note')
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => function ($matiere) {
                    return $matiere->getNom();
                }
            ])
            ->add('etudiants', EntityType::class, [
                'class' => Etudiant::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function () {
                    return $this->createQueryBuilder('etudiant')
                    ->setParameter('etudiant', $this);
                },
                'choice_label' => function ($er) {
                    return $er->getNom();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
