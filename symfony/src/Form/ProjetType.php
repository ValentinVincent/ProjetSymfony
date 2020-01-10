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
        $etudiant = $options['etudiant'];
        $builder
            ->add('nom')
            ->add('nbMax')
            ->add('note')
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'required' => false,
                'choice_label' => function ($matiere) {
                    return $matiere->getNom();
                }
            ])
            ->add('etudiants', EntityType::class, [
                'choice_value' => 'id',
                'class' => Etudiant::class,
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EtudiantRepository $er) use ($etudiant) {

                    $in = $er ->createQueryBuilder('b')
                        ->leftjoin('b.projets', 'p')
                        ->groupBy('b.id')
                        ->having('COUNT(p.id) < 4');
                    // return $in;  
                    return $er->createQueryBuilder('a')
                        ->andWhere('a.id in (:etudiant)')
                        ->orWhere('a.id IN ('.$in->getDQL().')')
                        ->setParameter('etudiant', $etudiant);
                },
                'choice_label' => function ($etudiant) {
                    return $etudiant->getNom();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
            'etudiant' => []
        ]);
    }
}
