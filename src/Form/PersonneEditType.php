<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Animal;
use App\Entity\Personne;
use App\Repository\AdresseRepository;
use App\Repository\AnimalRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'M',
                    'Femme' => 'F'
                ],
                'expanded' => true
            ])
            ->add('age', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 120
                ],
            ])
            ->add('adresse', EntityType::class, [
                'class' => Adresse::class,
                'query_builder' => function (AdresseRepository $adresseRepository) {
                    return $adresseRepository->createQueryBuilder('a')->orderBy('a.intitule', 'ASC');
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'title' => 'Aucune adresse'
                ],
                'required' => false
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
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
            'translation_domain' => 'forms',
        ]);
    }
}
