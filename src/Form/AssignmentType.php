<?php

namespace App\Form;

use App\Entity\Asset;
use App\Entity\Assignment;
use App\Entity\Consumable;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('assigned_at', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'attribution',
                'data' => new \DateTimeImmutable(),
            ])
            ->add('returned_at', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de retour',
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getPrenom() . ' ' . $user->getNom();
                },
                'label' => 'Utilisateur',
            ])
            ->add('asset', EntityType::class, [
                'class' => Asset::class,
                'choice_label' => function(Asset $asset) {
                    return $asset->getBrand() . ' ' . $asset->getModel() . ' (' . $asset->getSerialNumber() . ')';
                },
                'label' => 'Matériel',
                'required' => false,
            ])
            ->add('consumable', EntityType::class, [
                'class' => Consumable::class,
                'choice_label' => 'name',
                'label' => 'Consommable',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assignment::class,
        ]);
    }
}