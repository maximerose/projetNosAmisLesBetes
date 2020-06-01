<?php

namespace App\Form;

use App\Entity\Espece;
use App\Entity\Personne;
use App\Entity\Search\AnimalSearch;
use App\Repository\EspeceRepository;
use App\Repository\PersonneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('minAge', NumberType::class, [
                'required' => false
            ])
            ->add('maxAge', NumberType::class, [
                'required' => false
            ])
            ->add('especes', EntityType::class, [
                'class' => Espece::class,
                'query_builder' => function (EspeceRepository $especeRepository) {
                    return $especeRepository->createQueryBuilder('e')->orderBy('e.nom', 'ASC');
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucune espèce'
                ],
                'multiple' => true,
                'required' => false,
            ])
            ->add('maitres', EntityType::class, [
                'class' => Personne::class,
                'query_builder' => function (PersonneRepository $personneRepository) {
                    return $personneRepository->createQueryBuilder('p')->orderBy('p.nom', 'ASC');
                },
                'choice_label' => function (Personne $maitre) {
                    return $maitre->getNom() . ' | ' . $maitre->getAdresse();
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucun maitre'
                ],
                'multiple' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnimalSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
            'translation_domain' => 'forms',
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
