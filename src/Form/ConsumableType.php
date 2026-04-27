<?php

namespace App\Form;

use App\Entity\Consumable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsumableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom du consommable',
            ])
            ->add('stock_quantity', IntegerType::class, [
                'label' => 'Quantité en stock',
            ])
            ->add('stock_alert_threshold', IntegerType::class, [
                'label' => 'Seuil d\'alerte stock',
                'required' => false,
                'empty_data' => 5,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consumable::class,
        ]);
    }
}