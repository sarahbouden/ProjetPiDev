<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre de la publication',
                ],
                'invalid_message' => 'Veuillez saisir le titre de la publication.',
            ])
            ->add('Description', TextType::class, [
                'attr' => [
                    'placeholder' => 'Description',
                ],
                'invalid_message' => 'Veuillez saisir le titre de la publication.',
            ])
            ->add('UrlRessource', FileType::class, [
             'label' => 'Select your Picture',
             'required' => false, // Si le champ n'est pas obligatoire
             'data_class' => Publication::class,
            ]);
           /* ->add('Sauvegarder', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => [
                    'novalidate' => 'false',
                ]
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}