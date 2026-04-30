<?php

namespace App\Form;

use App\Entity\Asset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serial_number', null, [
                'label' => 'Numéro de série',
                'attr' => ['autocomplete' => 'off'],
            ])
            ->add('brand', null, [
                'label' => 'Marque',
            ])
            ->add('model', null, [
                'label' => 'Modèle',
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'PC / Laptop' => 'PC',
                    'Accessoire' => 'Accessoire',
                    'Écran' => 'Ecran',
                    'Téléphone' => 'Telephone',
                    'Autre' => 'Autre',
                ],
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => 'available',
                    'Attribué' => 'assigned',
                    'Maintenance' => 'maintenance',
                    'Perdu' => 'lost',
                    'Rebut' => 'retired',
                ],
            ])
            ->add('created_at', DateTimeType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Asset::class,
        ]);
    }
}