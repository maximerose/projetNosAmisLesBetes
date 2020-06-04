<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Animal;
use App\Entity\Search\PersonneSearch;
use App\Repository\AdresseRepository;
use App\Repository\AnimalRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('minAge', NumberType::class, [
                'required' => false
            ])
            ->add('maxAge', NumberType::class, [
                'required' => false
            ])
            ->add('sexes', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'M',
                    'Femme' => 'F'
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ])
            ->add('adresses', EntityType::class, [
                'class' => Adresse::class,
                'query_builder' => function (AdresseRepository $adresseRepository) {
                    return $adresseRepository->createQueryBuilder('a')->orderBy('a.intitule', 'ASC');
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucune adresse'
                ],
                'multiple' => true,
                'required' => false,
            ])
            ->add('animaux', EntityType::class, [
                'class' => Animal::class,
                'query_builder' => function (AnimalRepository $animalRepository) {
                    return $animalRepository->createQueryBuilder('a')->orderBy('a.nom', 'ASC');
                },
                'choice_label' => function (Animal $animal) {
                    return $animal->getNom() . ' (' . $animal->getEspece() . ')';
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucun animal'
                ],
                'multiple' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonneSearch::class,
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
