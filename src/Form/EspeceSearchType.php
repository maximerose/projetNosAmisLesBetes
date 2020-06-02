<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Search\EspeceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EspeceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EspeceSearch::class,
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
