<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Espece;
use App\Entity\Personne;
use App\Repository\EspeceRepository;
use App\Repository\PersonneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('age', NumberType::class, [
                'html5' => true,
                'label' => 'Âge',
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('espece', EntityType::class, [
                'class' => Espece::class,
                'label' => 'Espèce',
                'query_builder' => function (EspeceRepository $especeRepository) {
                    return $especeRepository->createQueryBuilder('e')->orderBy('e.nom', 'ASC');
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucune espèce sélectionnée...'
                ],
                'required' => false,
            ])
            ->add('maitres', EntityType::class, [
                'class' => Personne::class,
                'label' => 'Maître(s)',
                'query_builder' => function (PersonneRepository $personneRepository) {
                    return $personneRepository->createQueryBuilder('p')->orderBy('p.nom', 'ASC');
                },
                'choice_label' => function (Personne $maitre) {
                    return $maitre->getNom() . ' | ' . $maitre->getAdresse();
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucun maître sélectionné...'
                ],
                'multiple' => true,
                'required' => false,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
