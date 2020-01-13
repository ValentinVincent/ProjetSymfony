<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Intervenant;
use Symfony\Component\Form\AbstractType;
use App\Repository\IntervenantRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('intervenant', EntityType::class, [
                'class' => Intervenant::class,
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function(IntervenantRepository $int) use ($options) {
                    $firstRequest = $int->createQueryBuilder('inter')
                        ->leftJoin('inter.matiere', 'p') 
                        ->groupBy('inter.id')
                        ->having('count(p.id) < 2');
                    $secondRequest = $int->createQueryBuilder('o')
                        ->where('o.id in (' . $firstRequest->getDQL() . ')')
                        ->orWhere('o in (:intervenant)')
                        ->setParameter('intervenant', $options['intervenant']);
                        return $secondRequest;
                },
                'choice_label' => function ($intervenant) {
                    return $intervenant->getNom();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matiere::class,
            'intervenant' => []
        ]);
    }
}
